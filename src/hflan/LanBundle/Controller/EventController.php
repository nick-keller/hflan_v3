<?php

namespace hflan\LanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Request;

class EventController extends Controller
{

    /**
     * @Secure(roles="ROLE_RESPO")
     * @Template
     */
    public function newAction(Request $request)
    {

        return array(
            //'form' => $form->createView(),
        );
    }
}
