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
     * @var  Session
     */
    private $session;

    /**
     * @var UploadableManager
     */
    private $uploadableManager;

    /**
     * @Secure(roles="ROLE_PARTNER")
     * @Template
     */
    public function indexAction(Request $request)
    {
        $partners = $this->em->getRepository('hflanPartnerBundle:Partner')->findBy(array(), array('sortIndex' => 'ASC'));

        return array(
            'partners' => $partners,
        );
    }

    /**
     * @Secure(roles="ROLE_PARTNER")
     * @Template
     */
    public function newAction(Request $request)
    {
        $partner = new Partner;
        $form = $this->createForm(new PartnerType, $partner);

        if('POST' == $request->getMethod()){
            $form->handleRequest($request);

            if($form->isValid()){
                $this->em->persist($partner);
                if($partner->getFile()) $this->uploadableManager->markEntityToUpload($partner, $partner->getFile());
                $this->em->flush();

                return $this->redirect($this->generateUrl('hflan_partner_admin'));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Secure(roles="ROLE_PARTNER")
     * @Template
     */
    public function editAction(Request $request, Partner $partner)
    {
        $form = $this->createForm(new PartnerType, $partner);

        if('POST' == $request->getMethod()){
            $form->handleRequest($request);

            if($form->isValid()){
                $this->em->persist($partner);
                if($partner->getFile()) $this->uploadableManager->markEntityToUpload($partner, $partner->getFile());
                $this->em->flush();

                return $this->redirect($this->generateUrl('hflan_partner_admin'));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Secure(roles="ROLE_PARTNER")
     */
    public function moveAction(Request $request, Partner $partner, $dir)
    {
        $partner->setSortIndex(max(0, $partner->getSortIndex() + $dir));
        $this->em->persist($partner);
        $this->em->flush();

        return $this->redirect($this->generateUrl('hflan_partner_admin'));
    }
}
