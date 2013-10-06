<?php

namespace hflan\GuestbookBundle\Controller;

use hflan\GuestbookBundle\Entity\Feedback;
use hflan\GuestbookBundle\Form\FeedbackType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\Paginator;
use Symfony\Component\HttpFoundation\Request;

class PublicController extends Controller
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
     * @Template
     */
    public function indexAction(Request $request, $page)
    {
        $feedback = new Feedback;
        $form = $this->createForm(new FeedbackType, $feedback);

        if('POST' == $request->getMethod()){
            $form->handleRequest($request);

            if($form->isValid()){
                $this->em->persist($feedback);
                $this->em->flush();

                return $this->redirect($this->generateUrl('hflan_guestbook'));
            }
        }

        // --------------

        $feedbacks = $this->em->getRepository('hflanGuestbookBundle:Feedback')->queryAll();
        $pagination = $this->paginator->paginate($feedbacks, $page, 10);

        return array(
            'form' => $form->createView(),
            'pagination' => $pagination,
        );
    }

    /**
     * @Template
     */
    public function menuAction()
    {
        $feedback = $this->em->getRepository('hflanGuestbookBundle:Feedback')->findRandomOne();

        return array(
            'feedback' => $feedback,
        );
    }
}
