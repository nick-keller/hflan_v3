<?php

namespace hflan\LanBundle\Controller;

use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Doctrine\UserManager;
use hflan\LanBundle\Entity\Event;
use hflan\LanBundle\Entity\Player;
use hflan\LanBundle\Entity\Team;
use hflan\LanBundle\Entity\Tournament;
use hflan\LanBundle\Form\PlayerType;
use hflan\LanBundle\Form\TeamType;
use hflan\LanBundle\Form\TournamentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Request;

class PlayerController extends Controller
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @Secure(roles="ROLE_USER")
     * @Template
     */
    public function editAction(Request $request, Player $player)
    {
        /** @var Team $team */
        $team = $this->getUser()->getTeam();

        if($team->getInfoLocked())
            return $this->redirect($this->generateUrl('hflan_pay_team'));

        if($player->getTeam() != $team)
            return $this->redirect($this->generateUrl('hflan_edit_team'));

        $form = $this->createForm(new PlayerType, $player);
        $this->createFormBuilder();
        $fieldsForm = $this->get('hflan.factory.extra_fields_form')->createFromPlayer($player);

        if('POST' == $request->getMethod()) {
            $form->handleRequest($request);
            $fieldsForm->handleRequest($request);

            if($form->isValid() && $fieldsForm->isValid()){
                $player->setExtraFields($fieldsForm->getData());

                $this->em->persist($player);
                $this->em->flush();

                return $this->redirect($this->generateUrl('hflan_edit_team'));
            }
        }

        return array(
            'form' => $form->createView(),
            'fieldsForm' => $fieldsForm->createView(),
        );
    }
}
