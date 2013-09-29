<?php

namespace hflan\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use JMS\SecurityExtraBundle\Annotation\Secure;

class AdminController extends Controller
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @Secure(roles="ROLE_USER_MANAGER")
     * @Template
     */
    public function indexAction(Request $request)
    {
        $users = $this->em->getRepository('hflanUserBundle:User')->findBy(array());

        return array(
            'users' => $users,
        );
    }
}
