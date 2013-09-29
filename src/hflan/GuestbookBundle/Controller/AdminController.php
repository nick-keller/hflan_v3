<?php

namespace hflan\GuestbookBundle\Controller;

use hflan\GuestbookBundle\Entity\Feedback;
use hflan\GuestbookBundle\Form\FeedbackType;
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
     * @Secure(roles="ROLE_GUESTBOOK")
     * @Template
     */
    public function indexAction(Request $request, $page)
    {
        $feedbacks = $this->em->getRepository('hflanGuestbookBundle:Feedback')->queryAll();
        $pagination = $this->paginator->paginate($feedbacks, $page, 15);

        return array(
            'pagination' => $pagination,
        );
    }

    /**
     * @Secure(roles="ROLE_GUESTBOOK")
     */
    public function removeAction(Request $request, Feedback $feedback)
    {
        $this->em->remove($feedback);
        $this->em->flush();
        $this->session->getFlashBag()->add('success',
        'Commentaire supprimé.');

        return $this->redirect($this->generateUrl('hflan_guestbook_admin'));
    }
}
