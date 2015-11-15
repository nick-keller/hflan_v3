<?php

namespace hflan\PlayerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$events = $em->getRepository('hflanLanBundle:Event')->findAll();
    	$event_id = end($events)->getId();
    	$is_melee_edition = $em->getRepository('hflanLanBundle:Tournament')->findOneBy(array('event' => $event_id, 'game' => 'League of Legends'));
    	$has_csgo = $em->getRepository('hflanLanBundle:Tournament')->findOneBy(array('event' => $event_id, 'game' => 'Counter-Strike : Global Offensive'));

        return $this->render('hflanPlayerBundle:Default:index.html.twig', array(
			'event_id' => $event_id,
			'has_csgo' => $has_csgo,
			'is_melee_edition' => $is_melee_edition
		));
    }

    public function sc2Action($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$tournament = $em->getRepository('hflanLanBundle:Tournament')->findOneBy(array('event' => $id, 'gameType' => '1v1'));
    	
    	if($tournament == null) return $this->redirectToRoute('hflan_player');

    	$players = $em->getRepository('hflanLanBundle:Team')->findBy(array('tournament' => $tournament->getId(), 'paid' => '1'));
    	$current = count($players);

    	for($i = 0; $i < count($players); $i++)
    	{
    		$team = $em->getRepository('hflanLanBundle:Player')->findBy(array('team' => $players[$i]->getId()));
    		$teams[] = $team;
    	}

        return $this->render('hflanPlayerBundle:Default:list.html.twig', array(
        	'tournament' => $tournament,
			'teams' => $teams,
			'players' => $players,
			'current' => count($players)
		));
    }

    public function csgoAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$tournament = $em->getRepository('hflanLanBundle:Tournament')->findOneBy(array('event' => $id, 'game' => 'Counter-Strike : Global Offensive'));
    	
    	if($tournament == null) return $this->redirectToRoute('hflan_player');

    	$players = $em->getRepository('hflanLanBundle:Team')->findBy(array('tournament' => $tournament->getId(), 'paid' => '1'));

    	for($i = 0; $i < count($players); $i++)
    	{
    		$team = $em->getRepository('hflanLanBundle:Player')->findBy(array('team' => $players[$i]->getId()));
    		$teams[] = $team;
    	}
    	
        return $this->render('hflanPlayerBundle:Default:list.html.twig', array(
        	'tournament' => $tournament,
			'teams' => $teams,
			'players' => $players,
			'current' => count($players)
		));
    }

    public function lolAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$tournament = $em->getRepository('hflanLanBundle:Tournament')->findOneBy(array('event' => $id, 'game' => 'League of Legends'));
    	
    	if($tournament == null) return $this->redirectToRoute('hflan_player');

    	$players = $em->getRepository('hflanLanBundle:Team')->findBy(array('tournament' => $tournament->getId(), 'paid' => '1'));

    	for($i = 0; $i < count($players); $i++)
    	{
    		$team = $em->getRepository('hflanLanBundle:Player')->findBy(array('team' => $players[$i]->getId()));
    		$teams[] = $team;
    	}

        return $this->render('hflanPlayerBundle:Default:list.html.twig', array(
        	'tournament' => $tournament,
			'teams' => $teams,
			'players' => $players,
			'current' => count($players)
		));
    }

    public function ssbmAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$tournament = $em->getRepository('hflanLanBundle:Tournament')->findOneBy(array('event' => $id, 'game' => 'Super Smash Bros. Melee'));
    	
    	if($tournament == null) return $this->redirectToRoute('hflan_player');

    	$players = $em->getRepository('hflanLanBundle:Team')->findBy(array('tournament' => $tournament->getId(), 'paid' => '1'));

    	for($i = 0; $i < count($players); $i++)
    	{
    		$team = $em->getRepository('hflanLanBundle:Player')->findBy(array('team' => $players[$i]->getId()));
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
