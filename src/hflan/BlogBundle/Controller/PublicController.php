<?php

namespace hflan\BlogBundle\Controller;

use hflan\BlogBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\Paginator;

class PublicController extends Controller
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var Paginator
     */
    private $paginator;

    /**
     * @Template
     */
    public function homeAction()
    {
        $articles = $this->em->getRepository('hflanBlogBundle:Article')->queryAll();
        $pagination = $this->paginator->paginate($articles, 1, 5);

        return array(
            'articles' => $pagination,
        );
    }

    /**
     * @Template
     */
    public function indexAction($page)
    {
        $articles = $this->em->getRepository('hflanBlogBundle:Article')->queryAll();
        $pagination = $this->paginator->paginate($articles, $page, 7);

        return array(
            'pagination' => $pagination,
        );
    }

    /**
     * @Template
     */
    public function showAction(Article $article)
    {
        return array(
            'article' => $article,
        );
    }
}
