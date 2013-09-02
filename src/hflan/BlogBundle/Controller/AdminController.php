<?php

namespace hflan\BlogBundle\Controller;

use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use hflan\BlogBundle\Entity\Article;
use hflan\BlogBundle\Form\ArticleType;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Request;
use JMS\DiExtraBundle\Annotation as DI;

class AdminController extends Controller
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
     * @Secure(roles="ROLE_NEWSER")
     * @Template
     */
    public function indexAction($page)
    {
        $articles = $this->em->getRepository('hflanBlogBundle:Article')->queryAll();
        $pagination = $this->paginator->paginate($articles, $page, 2);

        return array(
            'pagination' => $pagination,
        );
    }

    /**
     * @Secure(roles="ROLE_NEWSER")
     * @Template
     */
    public function newAction(Request $request)
    {
        $article = new Article;
        $form = $this->createForm(new ArticleType, $article);

        if('POST' == $request->getMethod()){
            $form->handleRequest($request);

            if($form->isValid()){
                $this->em->persist($article);
                $this->em->flush();

                return $this->redirect($this->generateUrl('hflan_blog_admin'));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Secure(roles="ROLE_NEWSER")
     * @Template
     */
    public function editAction(Request $request, Article $article)
    {
        $form = $this->createForm(new ArticleType, $article);

        if('POST' == $request->getMethod()){
            $form->handleRequest($request);

            if($form->isValid()){
                $this->em->persist($article);
                $this->em->flush();

                return $this->redirect($this->generateUrl('hflan_blog_admin'));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }
}
