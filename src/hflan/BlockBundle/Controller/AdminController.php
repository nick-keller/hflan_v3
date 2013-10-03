<?php

namespace hflan\BlockBundle\Controller;

use Doctrine\ORM\EntityManager;
use hflan\BlockBundle\Entity\Block;
use hflan\BlockBundle\Form\BlockType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AdminController extends Controller
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @Secure(roles="ROLE_BLOCK")
     * @Template
     */
    public function indexAction()
    {
        $blocks = $this->em->getRepository('hflanBlockBundle:Block')->findAll();

        return array(
            'blocks' => $blocks,
        );
    }

    /**
     * @Secure(roles="ROLE_ADMIN")
     * @Template
     */
    public function newAction(Request $request)
    {
        $block = new Block;
        $form = $this->createForm(new BlockType, $block);

        if('POST' == $request->getMethod()){
            $form->handleRequest($request);

            if($form->isValid()){
                $this->em->persist($block);
                $this->em->flush();

                return $this->redirect($this->generateUrl('hflan_block_admin'));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Secure(roles="ROLE_BLOCK")
     * @Template
     */
    public function editAction(Request $request, Block $block)
    {
        $form = $this->createForm(new BlockType, $block);

        if('POST' == $request->getMethod()){
            $form->handleRequest($request);

            if($form->isValid()){
                $this->em->persist($block);
                $this->em->flush();

                return $this->redirect($this->generateUrl('hflan_block_admin'));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }
}
