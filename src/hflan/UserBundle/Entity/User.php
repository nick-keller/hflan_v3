<?php

namespace hflan\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use hflan\LanBundle\Entity\Team;

/**
 * User
 *
 * @ORM\Table(name="hf_user")
 * @ORM\Entity
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var  Team
     * @ORM\OneToOne(targetEntity="hflan\LanBundle\Entity\Team", inversedBy="user")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $team;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Team $team
     */
    public function setTeam(Team $team)
    {
        $this->team = $team;
    }

    /**
     * @return Team
     */
    public function getTeam()
    {
        return $this->team;
    }
}
