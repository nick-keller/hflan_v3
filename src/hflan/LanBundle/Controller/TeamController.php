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
     * @Secure(roles="IS_AUTHENTICATED_ANONYMOUSLY")
     * @Template
     */
    public function registerAction(Request $request)
    {
        if($this->getUser()) return $this->redirect($this->generateUrl('hflan_edit_team'));

        $team = new Team;
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
}
