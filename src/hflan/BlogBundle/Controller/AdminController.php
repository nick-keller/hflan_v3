<?php

namespace hflan\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use hflan\BlogBundle\Entity\Article;
use hflan\BlogBundle\Form\ArticleType;

class AdminController extends Controller
{
    /**
     * @Template
     */
    public function newAction()
    {
        $article = new Article;
        $form = $this->createForm(new ArticleType, $article);

        return array(
            'form' => $form->createView(),
        );
    }
}
