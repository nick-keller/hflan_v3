<?php

namespace hflan\BlogBundle\Controller;

use Doctrine\ORM\EntityManager;
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
     * @Secure(roles="ROLE_NEWSER")
     * @Template
     */
    public function indexAction()
    {
        return array();
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
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }
}
