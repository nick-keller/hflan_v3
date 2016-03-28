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

        if(count($teams)){
            $players = $this->em->getRepository('hflanLanBundle:Player')->findBy(array(
                'team' => $teams,
            ));

            $csv .= $this->generatePlayers($players);
        }

        return mb_convert_encoding($csv, "UTF-16", "UTF-8");
    }

    private function generateHeaders(Tournament $tournament)
    {
        $headers = array(1 => 'Pseudo', 'Prénom', 'Nom de famille', 'Email', 'Ordinateur', 'Date de naissance', 'Est mineur');

        foreach($tournament->getExtraFields() as $field)
            $headers[] = $field->getName();

        if($tournament->getNumberOfPlayerPerTeam() > 1)
            $headers[] = 'Team';

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

            foreach($player->getExtraFields() as $value)
                $data[] = $value;

            if($player->getTournament()->getNumberOfPlayerPerTeam() > 1)
                $data[] = (string) $player->getTeam();

            ksort($data);
            $csv .= implode(';', $data)."\n";
        }

        return $csv;
    }
}