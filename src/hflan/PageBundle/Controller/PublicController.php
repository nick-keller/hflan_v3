<?php

namespace hflan\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

class PublicController extends Controller
{
    /**
     * @Template
     */
    public function contactAction()
    {
        return array();
    }

    /**
     * @Secure(roles="ROLE_STAFF")
     * @Template
     */
    public function dashboardAction()
    {
        return array();
    }
}
