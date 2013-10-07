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
        if($this->getUser()) return $this->redirect($this->generateUrl('hflan_edit_team'));

        $team = new Team;
        if($tournament !== null) $team->setTournament($tournament);
        $nextEvent = $this->em->getRepository('hflanLanBundle:Event')->findNextEvent();
        $form = $this->createForm(new TeamType($nextEvent), $team);

        if('POST' == $request->getMethod()) {
            $form->handleRequest($request);

            if($form->isValid()) {
                $this->get('hflan.team_manager')->registerTeam($team);
                $this->session->getFlashBag()->add('success',
                    'Pour finaliser votre inscription, connectez vous avec votre adresse email et le mot de passe que vous venez de définir.');
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
    public function editAction(Request $request)
    {
        /** @var Team $team */
        $team = $this->getUser()->getTeam();

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

        if($team->getInfoLocked() == false){
            if(!$team->isValid())
                return $this->redirect($this->generateUrl('hflan_edit_team'));

            $team->setInfoLocked(true);
            $this->em->persist($team);
            $this->em->flush();
        }

        return array(
            'team' => $team,
            'tournament' => $team->getTournament(),
        );
    }

    /**
     * @Secure(roles="ROLE_USER")
     */
    public function upgradeAction(Request $request, Team $team)
    {
        $referer = $request->headers->get('referer') ?
            $request->headers->get('referer') :
            $this->generateUrl('hflan_team_show', array('id' => $team->getId()));

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
            $team->setPaid(true);
            $this->em->persist($team);
            $this->session->getFlashBag()->add('success', "Equipe passé en liste définitive");
        }

        $this->em->flush();

        return $this->redirect($referer);
    }

    /**
     * @Secure(roles="ROLE_USER")
     */
    public function downgradeAction(Request $request, Team $team)
    {
        $referer = $request->headers->get('referer') ?
            $request->headers->get('referer') :
            $this->generateUrl('hflan_team_show', array('id' => $team->getId()));

        if($team->getInfoLocked() && !$team->getPaid()){
            $team->setInfoLocked(false);
            $this->em->persist($team);
            $this->session->getFlashBag()->add('success', 'Equipe passé en liste pré-inscrite');
        }

        $this->em->flush();

        return $this->redirect($referer);
    }
}
