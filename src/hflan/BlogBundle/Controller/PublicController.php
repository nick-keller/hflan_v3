<?php

namespace hflan\BlogBundle\Controller;

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
    public function indexAction($page)
    {
        $articles = $this->em->getRepository('hflanBlogBundle:Article')->queryAll();
        $pagination = $this->paginator->paginate($articles, $page, 3);

        return array(
            'pagination' => $pagination,
        );
    }
}
