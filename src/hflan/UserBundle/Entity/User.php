<?php

namespace hflan\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use hflan\LanBundle\Entity\Team;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User
 *
 * @ORM\Table(name="hf_user")
 * @ORM\Entity
 * @UniqueEntity("username")
 * @UniqueEntity("email")
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
     * @var string
     * @Assert\NotBlank()
     */
    protected $username;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    protected $email;

    /**
     * Plain password. Used for model validation. Must not be persisted.
     *
     * @var string
     */
    protected $plainPassword;

    /**
     * @var  Team
     * @ORM\OneToOne(targetEntity="hflan\LanBundle\Entity\Team")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $team;

    /**
     * @var  \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="hflan\LanBundle\Entity\Team", mappedBy="user", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    protected $teams;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->teams = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
    
    /**
     * Add teams
     *
     * @param \hflan\LanBundle\Entity\Team $teams
     * @return User
     */
    public function addTeam(\hflan\LanBundle\Entity\Team $team)
    {
        $this->teams[] = $team;
        $team->setUser($this);
    
        return $this;
    }

    /**
     * Remove teams
     *
     * @param \hflan\LanBundle\Entity\Team $teams
     */
    public function removeTeam(\hflan\LanBundle\Entity\Team $teams)
    {
        $this->teams->removeElement($teams);
    }

    /**
     * Get teams
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTeams()
    {
        return $this->teams;
    }
}