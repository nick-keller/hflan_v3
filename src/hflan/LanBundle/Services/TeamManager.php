<?php
namespace hflan\LanBundle\Services;


use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Doctrine\UserManager;
use hflan\LanBundle\Entity\Event;
use hflan\LanBundle\Entity\Player;
use hflan\LanBundle\Entity\Team;
use hflan\LanBundle\Entity\Tournament;
use hflan\UserBundle\Entity\User;
use Symfony\Component\Templating\EngineInterface;

class TeamManager
{
    /**
     * @var EntityManager
     */
    private $em;
    /**
     * @var UserManager
     */
    private $um;

    /** @var  \Swift_Mailer */
    private $mailer;

    /**
     * @var EngineInterface
     */
    protected $templating;

    public function __construct(EntityManager $entityManager, UserManager $userManager, \Swift_Mailer $mailer, EngineInterface $templating)
    {
        $this->em = $entityManager;
        $this->um = $userManager;
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    public function registerTeam(Team $team)
    {
        $nextEvent = $this->em->getRepository('hflanLanBundle:Event')->findNextEvent();

        $this->saveTeam($team);
        $this->createUser($team);
        $this->createPlayers($team);
        $this->sendEmail($team, $nextEvent);

    }

    public function fetchTeamRegistrationData(Tournament $tournament = null)
    {
        if($tournament != null)
            $this->fetchSingleTeamRegistrationData($tournament);
        else {
            $tournaments = $this->em->getRepository('hflanLanBundle:Tournament')->findAll();

            foreach($tournaments as $tournament)
                $this->fetchSingleTeamRegistrationData($tournament);
        }
    }

    private function fetchSingleTeamRegistrationData(Tournament $tournament)
    {
        $data = $this->em->getRepository('hflanLanBundle:Team')->findTeamRegistrationData($tournament);

        foreach($data as $d)
        {
            if($d['infoLocked'] == false)
                $tournament->setPreRegistered((int) $d[1]);
            else if($d['paid'] == true)
                $tournament->setPaid((int) $d[1]);
            else
                $tournament->setPending((int) $d[1]);
        }
    }

    private function saveTeam(Team $team)
    {
        if($team->getEvent() === null)
            $team->setEvent($team->getTournament()->getEvent());

        $this->em->persist($team);
        $this->em->flush();
    }

    private function createUser(Team $team)
    {
        /** @var User $user */
        $user = $this->um->createUser();
        $user->setUsername($team->getEmail());
        $user->setEmail($team->getEmail());
        $user->setPlainPassword($team->getPlainPassword());
        $user->setTeam($team);
        $user->setEnabled(true);

        $this->um->updateUser($user);
    }

    private function createPlayers(Team $team)
    {
        $extraFields = $this->em->getRepository('hflanLanBundle:ExtraField')->getExtraFieldsArray($team->getTournament());

        for($i=0; $i<$team->getTournament()->getNumberOfPlayerPerTeam(); ++$i)
        {
            $player = new Player;
            $player->setTeam($team);
            $player->setTournament($team->getTournament());
            $player->setEvent($team->getTournament()->getEvent());
            $player->setExtraFields($extraFields);

            if($team->getTournament()->getNumberOfPlayerPerTeam() === 1)
                $player->setNickname($team->getName());

            if($team->getTournament()->getIsConsole())
                $player->setPcType('Aucun');

            $this->em->persist($player);
        }
        $this->em->flush();
    }

    private function sendEmail(Team $team, Event $event)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('hf.lan : Votre compte a bien été créé')
            ->setFrom('infos@hf-lan.fr')
            ->setTo($team->getEmail())
            ->setBody($this->templating->render(
                'hflanLanBundle:Mail:register.html.twig', array(
                    'event'      => $event,
                    'tournament' => $team->getTournament(),
                    'email'      => $team->getEmail(),
                    'password'   => $team->getPlainPassword(),
                    'team'       => $team,
                )),
                'text/html'
            )
        ;
        $this->mailer->send($message);
    }

    public function sendUpgradeEmail(Team $team, Event $event)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('hf.lan : Votre équipe a bien été inscrite')
            ->setFrom('infos@hf-lan.fr')
            ->setTo($team->getEmail())
            ->setBody($this->templating->render(
                'hflanLanBundle:Mail:confirmation.html.twig', array(
                    'event'      => $event,
                    'tournament' => $team->getTournament(),
                    'email'      => $team->getEmail(),
                    'team'       => $team,
                )),
                'text/html'
            )
        ;
        $this->mailer->send($message);
    }
}