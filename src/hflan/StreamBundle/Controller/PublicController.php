<?php

namespace hflan\StreamBundle\Controller;

use Doctrine\ORM\EntityManager;
use hflan\StreamBundle\Entity\Stream;
use hflan\StreamBundle\Form\StreamType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class PublicController extends Controller
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
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
     * @Template
     */
    public function showAction(Stream $stream)
    {
        return array(
            'stream' => $stream,
        );
    }
}
