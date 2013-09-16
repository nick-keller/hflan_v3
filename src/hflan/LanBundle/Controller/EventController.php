<?php

namespace hflan\LanBundle\Controller;

use Doctrine\ORM\EntityManager;
use hflan\LanBundle\Entity\Event;
use hflan\LanBundle\Entity\Export\EventExport;
use hflan\LanBundle\Form\EventType;
use hflan\LanBundle\Form\Export\EventExportType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Request;

class EventController extends Controller
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @Secure(roles="ROLE_RESPO")
     * @Template
     */
    public function indexAction()
    {
        $events = $this->em->getRepository('hflanLanBundle:Event')->findAll();
        $this->get('hflan.team_manager')->fetchTeamRegistrationData();

        return array(
            'events' => $events,
        );
    }

    /**
     * @Secure(roles="ROLE_RESPO")
     * @Template
     */
    public function newAction(Request $request)
    {
        $event = new Event;
        $form = $this->createForm(new EventType, $event);

        if('POST' == $request->getMethod()){
            $form->handleRequest($request);

            if($form->isValid()){
                $this->em->persist($event);
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
    public function editAction(Request $request, Event $event)
    {
        $form = $this->createForm(new EventType, $event);

        if('POST' == $request->getMethod()){
            $form->handleRequest($request);

            if($form->isValid()){
                $this->em->persist($event);
                $this->em->flush();

                return $this->redirect($this->generateUrl('hflan_event_admin'));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Template
     */
    public function menuAction()
    {
        $nextEvent = $this->em->getRepository('hflanLanBundle:Event')->findNextEvent();
        return array(
            'event' => $nextEvent,
        );
    }

    /**
     * @Template
     */
    public function exportAction(Request $request, Event $event)
    {
        $export = new EventExport($event);
        $form = $this->createForm(new EventExportType($event), $export);
        $emails = null;

        if('POST' == $request->getMethod()){
            $form->handleRequest($request);

            if($form->isValid()){
                $teams = $this->em->getRepository('hflanLanBundle:Team')->filter($export);
                $emails = $this->em->getRepository('hflanLanBundle:Player')->emails($teams);
            }
        }

        return array(
            'event' => $event,
            'form' => $form->createView(),
            'emails' => $emails,
        );
    }
}
