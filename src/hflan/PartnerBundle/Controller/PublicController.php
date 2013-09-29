<?php

namespace hflan\PartnerBundle\Controller;

use hflan\PartnerBundle\Entity\Partner;
use hflan\PartnerBundle\Form\PartnerType;
use Stof\DoctrineExtensionsBundle\Uploadable\UploadableManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\Paginator;
use Symfony\Component\HttpFoundation\Request;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Session\Session;

class PublicController extends Controller
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @Template
     */
    public function menuAction()
    {
        $partners = $this->em->getRepository('hflanPartnerBundle:Partner')->findBy(array(), array('sortIndex' => 'ASC'));

        return array(
            'partners' => $partners,
        );
    }
}
