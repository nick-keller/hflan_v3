<?php
namespace hflan\LanBundle\Services;


use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Doctrine\UserManager;
use hflan\LanBundle\Entity\Event;
use hflan\LanBundle\Entity\Player;
use hflan\LanBundle\Entity\Team;
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

    private function saveTeam(Team $team)
    {
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

        $this->um->updateUser($user);
    }

    private function createPlayers(Team $team)
    {
        $extraFields = $this->em->getRepository('hflanLanBundle:ExtraField')->getExtraFieldsArray($team->getTournament());

        for($i=0; $i<$team->getTournament()->getNumberOfPlayerPerTeam(); ++$i)
        {
            $player = new Player;
            $player->setTournament($team->getTournament());
            $player->setTeam($team);
            $player->setExtraFields($extraFields);

            $this->em->persist($player);
        }
        $this->em->flush();
    }

    private function sendEmail(Team $team, Event $event)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('hf.lan : Votre compte a bien été créé')
            ->setFrom('noreply@hf-lan.fr')
            ->setTo($team->getEmail())
            ->setBody($this->templating->render(
                'hflanLanBundle:Mail:register.html.twig', array(
                'event' => $event,
                'tournament' => $team->getTournament(),
                'email' => $team->getEmail(),
                'password' => $team->getPlainPassword(),
                'team' => $team,
            )))
        ;
        $this->mailer->send($message);
    }
}