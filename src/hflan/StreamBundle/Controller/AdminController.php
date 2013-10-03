<?php

namespace hflan\StreamBundle\Controller;

use Doctrine\ORM\EntityManager;
use hflan\StreamBundle\Entity\Stream;
use hflan\StreamBundle\Form\StreamType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @Secure(roles="ROLE_STREAM")
     * @Template
     */
    public function indexAction()
    {
        $streams = $this->em->getRepository('hflanStreamBundle:Stream')->findAll();

        return array(
            'streams' => $streams,
        );
    }

    /**
     * @Secure(roles="ROLE_STREAM")
     * @Template
     */
    public function newAction(Request $request)
    {
        $stream = new Stream;
        $form = $this->createForm(new StreamType, $stream);

        if('POST' == $request->getMethod()){
            $form->handleRequest($request);

            if($form->isValid()){
                $this->em->persist($stream);
                $this->em->flush();

                return $this->redirect($this->generateUrl('hflan_stream_admin'));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Secure(roles="ROLE_STREAM")
     * @Template
     */
    public function editAction(Request $request, Stream $stream)
    {
        $form = $this->createForm(new StreamType, $stream);

        if('POST' == $request->getMethod()){
            $form->handleRequest($request);

            if($form->isValid()){
                $this->em->persist($stream);
                $this->em->flush();

                return $this->redirect($this->generateUrl('hflan_stream_admin'));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Secure(roles="ROLE_STREAM")
     * @Template
     */
    public function removeAction(Request $request, Stream $stream)
    {
        $this->em->remove($stream);
        $this->em->flush();

        return $this->redirect($this->generateUrl('hflan_stream_admin'));
    }
}
