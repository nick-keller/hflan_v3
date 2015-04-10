<?php

namespace hflan\LanBundle\Controller;

use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Doctrine\UserManager;
use hflan\LanBundle\Entity\Event;
use hflan\LanBundle\Entity\Team;
use hflan\LanBundle\Entity\Tournament;
use hflan\LanBundle\Form\TeamType;
use hflan\LanBundle\Form\TournamentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;

class TeamController extends Controller
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var  Session
     */
    private $session;

    /**
     * @Secure(roles="ROLE_USER")
     * @Template
     */
    public function showAction(Team $team)
    {
        return array(
            'team' => $team,
        );
    }

    /**
     * @Secure(roles="IS_AUTHENTICATED_ANONYMOUSLY")
     * @Template
     */
    public function registerAction(Request $request, Tournament $tournament = null)
    {
        $again = (null !== $this->getUser());

        $team = new Team();
        if($tournament !== null) $team->setTournament($tournament);

        $this->get('hflan.team_manager')->fetchTeamRegistrationData($tournament);
        if ($tournament !== null && $tournament->getFillingRatio() >= 100)
            $this->session->getFlashBag()->add('warning', 'Le tournois est complet, vous ne serez que sur liste d\'attente');

        $nextEvent = $this->em->getRepository('hflanLanBundle:Event')->findNextEvent();
        $form = $this->createForm(new TeamType($nextEvent, $again), $team);

        if('POST' == $request->getMethod()) {
            $form->handleRequest($request);

            if(!$again && $form->isValid()) {
               if ($this->get('hflan.team_manager')->registerTeam($team))
               {
                    $this->session->getFlashBag()->add('success',
                        'Pour finaliser votre inscription, connectez vous avec votre adresse email et le mot de passe que vous venez de définir.');
                    return $this->redirect($this->generateUrl('hflan_edit_team'));
               }
               else
               {
                    $this->session->getFlashBag()->add('error',
                        'Un utilisateur avec la même adresse est déjà inscrits à '.$team->getEvent()->getName());
               }
            } elseif (null !== $team->getName() && $form->isValid()) {
                $this->get('hflan.team_manager')->createTeam($team, $this->getUser());
                            
                $this->session->getFlashBag()->add('success',
                    'Vous pouvez maintenant finaliser votre inscription.');

                return $this->redirect($this->generateUrl('hflan_edit_team'));
            }
        }

        return array(
            'form' => $form->createView(),
            'event' => $nextEvent,
        );
    }

    /**
     * @Secure(roles="ROLE_USER")
     * @Template
     */
    public function registrationClosedAction(Request $request)
    {
        /** @var Team $team */
        $team = $this->getUser()->getTeam();

        return array(
            'team' => $team,
            'tournament' => $team->getTournament(),
        );
    }

    /**
     * @Secure(roles="ROLE_USER")
     * @Template
     */
    public function editAction(Request $request)
    {
        /** @var Team $team */
        $team = $this->getUser()->getTeam();

        if (new \DateTime() > $team->getEvent()->getRegistrationCloseAt()) 
            return $this->redirect($this->generateUrl('hflan_team_registration_closed'));

        if($team->getInfoLocked())
            return $this->redirect($this->generateUrl('hflan_pay_team'));

        return array(
            'team' => $team,
            'tournament' => $team->getTournament(),
        );
    }

    /**
     * @Secure(roles="ROLE_USER")
     * @Template
     */
    public function payAction(Request $request)
    {
        /** @var Team $team */
        $team = $this->getUser()->getTeam();
        $this->get('hflan.team_manager')->fetchTeamRegistrationData();

        if($team->getInfoLocked() == false){
            if(!$team->isValid())
                return $this->redirect($this->generateUrl('hflan_edit_team'));

            $team->setInfoLocked(true);

            if ($team->getTournament()->getIsPaymentOnTheSpot() && $team->getTournament()->getFillingRatio() < 100)
            {
                $team->setPaid(true);
                $this->get('hflan.team_manager')->sendUpgradeEmail($team, $team->getTournament()->getEvent());
            }

            $this->em->persist($team);
            $this->em->flush();
        }


        if ($request->isMethod('POST')) {
            // CLE DE BEN, A CHANGER POUR LIVE
            // Secret key.
            // https://dashboard.stripe.com/account/apikeys
            \Stripe\Stripe::setApiKey($this->container->getParameter('stripe.privateKey'));

            // Reccupere le token correspondant a la cb envoyee au formulaire
            $token = $request->request->get('stripeToken');

            // Create the charge on Stripe's servers - this will charge the user's card
            try {
                $charge = \Stripe\Charge::create(array(
                    "amount" => $team->getTournament()->getTotalPrice() * 100, // amount in cents, again
                    "currency" => "eur",
                    "source" => $token,
                    "description" => $team->getName(),
                    "receipt_email" => $team->getEmail()
                ));

                $team->setPaid(true);
                $this->get('hflan.team_manager')->sendUpgradeEmail($team, $team->getTournament()->getEvent());

                $this->em->persist($team);
                $this->em->flush();


            } catch(\Stripe\Error\Card $e) {
              $this->session->getFlashBag()->add('error', 'Carte bancaire refusée.');
            }
        }

        return array(
            'team' => $team,
            'tournament' => $team->getTournament(),
        );
    }

    /**
     * @Secure(roles="ROLE_RESPO")
     */
    public function upgradeAction(Request $request, Team $team)
    {
        // $referer = $request->headers->get('referer') ?
        //     $request->headers->get('referer') :
        //     $this->generateUrl('hflan_team_show', array('id' => $team->getId()));

        if($team->getInfoLocked() == false){
            if($team->isValid()){
                $team->setInfoLocked(true);
                $this->em->persist($team);
                $this->session->getFlashBag()->add('success', "Equipe passé en liste d'attente");
            } else {
                $this->session->getFlashBag()->add('error', "Impossible de passer cette équipe en liste d'attente, les informations ne sont pas complètes !");
            }
        }
        else if($team->getPaid() == false){
            $this->get('hflan.team_manager')->fetchTeamRegistrationData();
            if ($team->getTournament()->getFillingRatio() < 100)
            {
                $team->setPaid(true);
                $this->get('hflan.team_manager')->sendUpgradeEmail($team, $team->getTournament()->getEvent());
                $this->em->persist($team);
                $this->session->getFlashBag()->add('success', "Equipe passé en liste définitive");
            }
            else
            {
                $this->session->getFlashBag()->add('error', "Le tournois est complet.");
            }
        }

        $this->em->flush();

        return $this->redirect($this->generateUrl('hflan_team_show', array('id' => $team->getId())));
    }

    /**
     * @Secure(roles="ROLE_RESPO")
     * @Template
     */
    public function upgradeConfirmationAction(Request $request, Team $team)
    {
        if($team->getInfoLocked() == false){
            return $this->redirect($this->generateUrl('hflan_team_upgrade', array('id' => $team->getId())), 301);
        }
        else if($team->getPaid() == false){
            return array(
                'team' => $team,
                'tournament' => $team->getTournament(),
            );
        }
    }

    /**
     * @Secure(roles="ROLE_RESPO")
     */
    public function downgradeAction(Request $request, Team $team)
    {
        // $referer = $request->headers->get('referer') ?
        //     $request->headers->get('referer') :
        //     $this->generateUrl('hflan_team_show', array('id' => $team->getId()));

        if($team->getInfoLocked() && !$team->getPaid()){
            $team->setInfoLocked(false);
            $this->em->persist($team);
            $this->session->getFlashBag()->add('success', 'Equipe passé en liste pré-inscrite');
        }

        if ($team->getPaid() && $this->get('security.context')->isGranted('ROLE_SUPER_ADMIN'))
        {
            $team->setPaid(false);
            $this->em->persist($team);
            $this->session->getFlashBag()->add('success', 'Equipe passé en liste d\'attente');
        }

        $this->em->flush();

        return $this->redirect($this->generateUrl('hflan_team_show', array('id' => $team->getId())));
    }

    /**
     * @Secure(roles="ROLE_RESPO")
     * @Template
     */
    public function downgradeConfirmationAction(Request $request, Team $team)
    {
        return array(
            'team' => $team,
            'tournament' => $team->getTournament(),
        );
    }

    /**
     * @Secure(roles="ROLE_SUPER_ADMIN")
     */
    public function removeAction(Team $team)
    {
        if($team->getPaid() && !$team->getTournament()->getIsPaymentOnTheSpot()){
            $this->session->getFlashBag()->add('error', "Impossible de supprimer une team qui a payé voyons !");
                
            return $this->redirect($this->generateUrl('hflan_team_show', array('id' => $team->getId())));
        }

        $this->em->remove($team);
        $this->em->flush();

        return $this->redirect($this->generateUrl('hflan_event_admin'));
    }

    /**
     * @Secure(roles="ROLE_SUPER_ADMIN")
     * @Template
     */
    public function removeConfirmationAction(Team $team)
    {
        if($team->getPaid() && !$team->getTournament()->getIsPaymentOnTheSpot()){
            $this->session->getFlashBag()->add('error', "Impossible de supprimer une team qui a payé voyons !");

            $referer = $request->headers->get('referer') ?
                $request->headers->get('referer') :
                $this->generateUrl('hflan_team_show', array('id' => $team->getId()));
                
            return $this->redirect($referer);
        }

        return array(
            'team' => $team,
            'tournament' => $team->getTournament(),
        );
    }

    public function updateDatabaseAction()
    {
        $teams = $this->em->getRepository('hflanLanBundle:Team')->findAll();

        //var_dump($teams);

        foreach ($teams as $team) {
            if (0 == $team->getEvent()->getId())
            {
                $team->setEvent($team->getTournament()->getEvent());
                // $this->em->persist($team);
            }
            //var_dump($team->getEvent()->getId());
        }

        // $this->em->flush();

        $users = $this->em->getRepository('hflanUserBundle:User')->findAll();

        //var_dump($users);

        foreach ($users as $user) {
            // if (0 == $user->getTeams()->count())
            // {
            //     if (null !== $user->getTeam()) {
            //         $user->addTeam($user->getTeam());
            //         $this->em->persist($user);
            //     }
            // }
            var_dump($user->getTeams()->count());
        }

        $this->em->flush();
        return new Response('<html><body>Coucou</body></html>');
    }
}
