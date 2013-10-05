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
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;
use Symfony\Component\HttpFoundation\Session\Session;

class EventController extends Controller
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
        if(count($event->getPlayers())){
            $this->session->getFlashBag()->add('error', 'Vous ne pouvez plus éditer cet évènement, des joueurs sont déjà inscrits.');
            return $this->redirect($this->generateUrl('hflan_event_admin'));
        }

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
     * @PreAuthorize("hasRole('ROLE_REMOVE') and hasRole('ROLE_RESPO')")
     * @Template
     */
    public function removeAction(Event $event)
    {
        if(count($event->getPlayers()))
            $this->session->getFlashBag()->add('error', 'Vous ne pouvez plus supprimer cet évènement, des joueurs sont déjà inscrits.');
        else{
            $this->em->remove($event);
            $this->em->flush();
        }

        return $this->redirect($this->generateUrl('hflan_event_admin'));
    }

    /**
     * @Template
     */
    public function menuAction()
    {
        return array();
    }

    /**
     * @Secure(roles="ROLE_RESPO")
     * @Template
     */
    public function exportAction(Request $request, Event $event)
    {
        $export = new EventExport;
        $form = $this->createForm(new EventExportType($event), $export);
        $emails = null;
        $count = 0;

        if('POST' == $request->getMethod()){
            $form->handleRequest($request);

            if($form->isValid()){
                $teams = $this->em->getRepository('hflanLanBundle:Team')->filter($export);
                $emails = $this->em->getRepository('hflanLanBundle:Player')->emails($teams);
                $count = count($emails);
                $emails = preg_replace('#;+#', ';', implode(';', $emails));
            }
        }

        return array(
            'event' => $event,
            'form' => $form->createView(),
            'emails' => $emails,
            'count' => $count,
        );
    }
}
