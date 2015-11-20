<?php

namespace hflan\PlayerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $next_event = $em->getRepository('hflanLanBundle:Event')->findNextEvent();

        return $this->render('hflanPlayerBundle:Default:index.html.twig', array(
            'next_event' => $next_event
        ));
    }

    public function listAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $tournament = $em->getRepository('hflanLanBundle:Tournament')->findOneBySlug($slug);

        if($tournament == null) return $this->redirectToRoute('hflan_player');

        $players = $em->getRepository('hflanLanBundle:Team')->findBy(array('tournament' => $tournament->getId(), 'paid' => '1'));

        for($i = 0; $i < count($players); $i++)
        {
            $team = $em->getRepository('hflanLanBundle:Player')->findByTeam($players[$i]->getId());
            $teams[] = $team;
        }

        return $this->render('hflanPlayerBundle:Default:list.html.twig', array(
            'tournament' => $tournament,
            'teams' => $teams,
            'players' => $players,
            'current' => count($players)
        ));
    }
}
