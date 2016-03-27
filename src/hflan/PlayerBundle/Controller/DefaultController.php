<?php

namespace hflan\PlayerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use hflan\BlogBundle\Entity\Article;
use \DateTime;

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
            'teams' => $players ? $teams : null,
            'players' => $players,
            'current' => count($players)
        ));
    }

    public function generateAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $next_event = $em->getRepository('hflanLanBundle:Event')->findNextEvent();

        if($next_event == null) return $this->redirectToRoute('hflan_blog_admin');

        $tournaments = $em->getRepository('hflanLanBundle:Tournament')->findByEvent($next_event);

        foreach($tournaments as $tournament)
        {
            if($tournament->getGameType() != 'Tous jeux' && $tournament->getGameType() != 'Spectateur')
            {
                $players = $em->getRepository('hflanLanBundle:Team')->findBy(array('tournament' => $tournament->getId(), 'paid' => '1'));

                for($i = 0; $i < count($players); $i++)
                {
                    $team = $em->getRepository('hflanLanBundle:Player')->findByTeam($players[$i]->getId());
                    $teams[] = $team;
                }

                $title = $next_event->getName().' - Liste des joueurs '.$tournament->getGame();
                $previous = $em->getRepository('hflanBlogBundle:Article')->findOneByTitle($title);
                if($previous == null) $article = new Article();
                else $article = $previous;
                $article->setTitle($title);
                $article->setAuthor($user);
                $article->setCreatedAt(new DateTime());
                $article->setPublished(1);
                $article->setLang('fr');
                $article->setContent(
                    $this->renderView('hflanPlayerBundle:Default:blog.html.twig', array(
                    'tournament' => $tournament,
                    'teams' => $players ? $teams : null,
                    'players' => $players,
                    'current' => count($players)
                    ))
                );
                $em->persist($article);
                $em->flush();
            }
        }

        return $this->redirectToRoute('hflan_blog_admin');
    }
}