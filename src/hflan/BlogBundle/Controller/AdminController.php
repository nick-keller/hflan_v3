<?php

namespace hflan\BlogBundle\Controller;

use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\Paginator;
use Stof\DoctrineExtensionsBundle\Uploadable\UploadableManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use hflan\BlogBundle\Entity\Article;
use hflan\BlogBundle\Form\ArticleType;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

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
     * @var UploadableManager
     */
    private $uploadableManager;

    /**
     * @var  Session
     */
    private $session;

    /**
     * @Secure(roles="ROLE_NEWSER")
     * @Template
     */
    public function indexAction($page)
    {
        $articles = $this->em->getRepository('hflanBlogBundle:Article')->queryAll();
        $pagination = $this->paginator->paginate($articles, $page, 10);

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
                if($article->getFile()) $this->uploadableManager->markEntityToUpload($article, $article->getFile());
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
                if($article->getFile()) $this->uploadableManager->markEntityToUpload($article, $article->getFile());
                $this->em->flush();

                return $this->redirect($this->generateUrl('hflan_blog_admin'));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @PreAuthorize("hasRole('ROLE_REMOVE') and hasRole('ROLE_NEWSER')")
     * @Template
     */
    public function removeAction(Article $article)
    {
        $this->em->remove($article);
        $this->em->flush();
        $this->session->getFlashBag()->add('success', 'Article supprimé.');

        return $this->redirect($this->generateUrl('hflan_blog_admin'));
    }
}
