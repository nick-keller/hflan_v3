<?php
namespace hflan\LanBundle\Services;

use Doctrine\ORM\EntityManager;
use hflan\LanBundle\Entity\Player;
use hflan\LanBundle\Entity\Tournament;

class CsvGenerator
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function generate(Tournament $tournament)
    {
        $csv = $this->generateHeaders($tournament);

        $teams = $this->em->getRepository('hflanLanBundle:Team')->findBy(array(
            'tournament' => $tournament,
            'paid' => true,
        ));

        $players = $this->em->getRepository('hflanLanBundle:Player')->findBy(array(
            'team' => $teams,
        ));

        $csv .= $this->generatePlayers($players);

        return $csv;
    }

    private function generateHeaders(Tournament $tournament)
    {
        $headers = array(1 => 'Pseudo', 'Prénom', 'Nom de famille', 'Email', 'Ordinateur', 'Date de naissance', 'Est mineur');

        if($tournament->getNumberOfPlayerPerTeam() > 1)
            $headers[0] = 'Team';

        foreach($tournament->getExtraFields() as $field)
            $headers[] = $field->getName();

        ksort($headers);
        return implode(';', $headers)."\n";
    }

    private function generatePlayers(array $players)
    {
        $csv = '';

        foreach($players as $player){
            /** @var Player $player */
            $player;

            $data = array(1 =>
                $player->getNickname(),
                $player->getFirstName(),
                $player->getLastName(),
                $player->getEmail(),
                $player->getPcType(),
                $player->getBirthday()->format('d/m/Y'),
                $player->isMinor() ? 'oui' : '',
            );

            if($player->getTournament()->getNumberOfPlayerPerTeam() > 1)
                $data[0] = (string) $player->getTeam();

            foreach($player->getExtraFields() as $value)
                $data[] = $value;

            ksort($data);
            $csv .= implode(';', $data)."\n";
        }

        return $csv;
    }
}