<?php

namespace hflan\LanBundle\Controller;

use hflan\LanBundle\Entity\Event;
use hflan\LanBundle\Form\EventType;
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
}
