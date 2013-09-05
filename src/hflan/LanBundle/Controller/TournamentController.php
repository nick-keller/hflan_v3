<?php

namespace hflan\LanBundle\Controller;

use hflan\LanBundle\Entity\Event;
use hflan\LanBundle\Entity\Tournament;
use hflan\LanBundle\Form\TournamentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Request;

class TournamentController extends Controller
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @Secure(roles="ROLE_RESPO")
     * @Template
     */
    public function newAction(Request $request, Event $event)
    {
        $tournament = new Tournament($event);
        $form = $this->createForm(new TournamentType, $tournament);

        if('POST' == $request->getMethod()){
            $form->handleRequest($request);

            if($form->isValid()){
                $this->em->persist($tournament);
                $this->em->flush();

                return $this->redirect($this->generateUrl('hflan_event_admin'));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Secure(roles="ROLE_RESPO")
     * @Template
     */
    public function editAction(Request $request, Tournament $tournament)
    {
        $form = $this->createForm(new TournamentType, $tournament);

        if('POST' == $request->getMethod()){
            $form->handleRequest($request);

            if($form->isValid()){
                $this->em->persist($tournament);
                $this->em->flush();

                return $this->redirect($this->generateUrl('hflan_event_admin'));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }
}
