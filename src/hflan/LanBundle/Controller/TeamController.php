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

class TeamController extends Controller
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @Secure(roles="IS_AUTHENTICATED_ANONYMOUSLY")
     * @Template
     */
    public function registerAction(Request $request)
    {
        $team = new Team;
        $nextEvent = $this->em->getRepository('hflanLanBundle:Event')->findNextEvent();
        $form = $this->createForm(new TeamType($nextEvent), $team);

        if('POST' == $request->getMethod())
        {
            $form->handleRequest($request);

            if($form->isValid())
            {
                $this->get('hflan.team_manager')->registerTeam($team);
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
        return array(
            'team' => $this->getUser()->getTeam(),
            'tournament' => $this->getUser()->getTeam()->getTournament(),
        );
    }
}
