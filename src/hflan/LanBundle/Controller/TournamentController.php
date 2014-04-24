<?php

namespace hflan\LanBundle\Controller;

use Doctrine\ORM\EntityManager;
use hflan\LanBundle\Entity\Event;
use hflan\LanBundle\Entity\Export\EventExport;
use hflan\LanBundle\Entity\Tournament;
use hflan\LanBundle\Form\TournamentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;
use Symfony\Component\HttpFoundation\Session\Session;

class TournamentController extends Controller
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
    public function showAction(Tournament $tournament)
    {
        $teamRepo = $this->em->getRepository('hflanLanBundle:Team');
        $teams = array(
            'blank' => $teamRepo->findTeams($tournament, EventExport::LIST_BLANK),
            'locked' => $teamRepo->findTeams($tournament, EventExport::LIST_LOCKED),
            'paid' => $teamRepo->findTeams($tournament, EventExport::LIST_PAID),
        );

        return array(
            'tournament' => $tournament,
            'teams' => $teams,
        );
    }

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
        if(count($tournament->getPlayers()) && !$this->get('security.context')->isGranted('ROLE_ADMIN')){
            $this->session->getFlashBag()->add('error', 'Vous ne pouvez plus éditer ce tournoi, des joueurs sont déjà inscrits.');
            return $this->redirect($this->generateUrl('hflan_event_admin'));
        }

        // Fields before edit
        $originalFields = array();
        foreach($tournament->getExtraFields() as $field) $originalFields[] = $field;

        $form = $this->createForm(new TournamentType, $tournament);

        if('POST' == $request->getMethod()){
            $form->handleRequest($request);

            if($form->isValid()){
                // filter $originalFields so it only has deleted fields
                foreach ($tournament->getExtraFields() as $field)
                    foreach ($originalFields as $key => $toDel)
                        if ($toDel->getId() === $field->getId())
                            unset($originalFields[$key]);

                foreach($originalFields as $field)
                    $this->em->remove(($field));

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
     * @PreAuthorize("hasRole('ROLE_REMOVE') and hasRole('ROLE_SUPER_ADMIN')")
     * @Template
     */
    public function removeAction(Tournament $tournament)
    {
        if(count($tournament->getPlayers()))
            $this->session->getFlashBag()->add('error', 'Vous ne pouvez plus supprimer ce tournoi, des joueurs sont déjà inscrits.');
        else{
            $this->em->remove($tournament);
            $this->em->flush();
            $this->session->getFlashBag()->add('success', 'L\'équipe a bien été supprimée du tournois');
        }

        return $this->redirect($this->generateUrl('hflan_event_admin'));
    }

    public function exportAction(Tournament $tournament)
    {
        $response = new Response();
        $response->setContent($this->get('hflan.csv_generator')->generate($tournament));
        $response->headers->set('Content-Type', 'text/csv');

        $filename = $tournament->getEvent()->getSlug().'_'.$tournament->getSlug();
        $response->headers->set('Content-Disposition', 'attachment; filename="'.$filename.'.csv"');

        return $response;
    }
}
