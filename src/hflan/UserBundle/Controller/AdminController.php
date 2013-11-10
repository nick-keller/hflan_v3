<?php

namespace hflan\UserBundle\Controller;

use hflan\UserBundle\Entity\User;
use hflan\UserBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;
use FOS\UserBundle\Doctrine\UserManager;
use Symfony\Component\HttpFoundation\Session\Session;

class AdminController extends Controller
{
    /**
     * @var EntityManager
     */
    private $em;
    /**
     * @var UserManager
     */
    private $um;

    /**
     * @var  Session
     */
    private $session;

    /**
     * @Secure(roles="ROLE_USER_MANAGER")
     * @Template
     */
    public function indexAction()
    {
        $users = $this->em->getRepository('hflanUserBundle:User')->findBy(array('team'=>null));

        return array(
            'users' => $users,
        );
    }

    /**
     * @Secure(roles="ROLE_USER_MANAGER")
     * @Template
     */
    public function newAction(Request $request)
    {
        /** @var User $user */
        $user = $this->um->createUser();
        $user->setEnabled(true);

        $form = $this->createForm(new UserType, $user);

        if('POST' == $request->getMethod()){
            $form->handleRequest($request);

            if($form->isValid()){
                if(($user->hasRole('ROLE_ADMIN') || $user->hasRole('ROLE_REMOVE')) && !$this->get('security.context')->isGranted('ROLE_ADMIN')){
                    $this->session->getFlashBag()->add('error', 'Vous ne pouvez pas attibuer certains droits.');
                }
                else{
                    $this->um->updateUser($user);

                    return $this->redirect($this->generateUrl('hflan_users_admin'));
                }
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Secure(roles="ROLE_USER_MANAGER")
     * @Template
     */
    public function editAction(Request $request, User $user)
    {
        if($user->hasRole('ROLE_SUPER_ADMIN')){
            $this->session->getFlashBag()->add('error', 'Les voies du seigneur sont impénétrables...');

            return $this->redirect($this->generateUrl('hflan_users_admin'));
        }

        if(($user->hasRole('ROLE_ADMIN') || $user->hasRole('ROLE_REMOVE')) && !$this->get('security.context')->isGranted('ROLE_ADMIN')){
            $this->session->getFlashBag()->add('error', 'Vous devez être admin pour éditer cet utilisateur.');

            return $this->redirect($this->generateUrl('hflan_users_admin'));
        }

        $form = $this->createForm(new UserType, $user);

        if('POST' == $request->getMethod()){
            $form->handleRequest($request);

            if($form->isValid()){
                if(($user->hasRole('ROLE_ADMIN') || $user->hasRole('ROLE_REMOVE')) && !$this->get('security.context')->isGranted('ROLE_ADMIN')){
                    $this->session->getFlashBag()->add('error', 'Vous ne pouvez pas attibuer certains droits.');
                }
                else{
                    $this->um->updateUser($user);

                    return $this->redirect($this->generateUrl('hflan_users_admin'));
                }
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @PreAuthorize("hasRole('ROLE_REMOVE') and hasRole('ROLE_USER_MANAGER')")
     * @Template
     */
    public function removeAction(User $user)
    {
        if($user->hasRole('ROLE_ADMIN'))
            $this->session->getFlashBag()->add('error', 'Vous ne pouvez pas supprimer un admin.');
        else
            $this->um->deleteUser($user);

        return $this->redirect($this->generateUrl('hflan_users_admin'));
    }
}
