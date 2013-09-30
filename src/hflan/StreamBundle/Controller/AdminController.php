<?php

namespace hflan\StreamBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AdminController extends Controller
{
    /**
     * @Secure(roles="ROLE_STREAM")
     * @Template
     */
    public function indexAction()
    {
        return array();
    }
}
