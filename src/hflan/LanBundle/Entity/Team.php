<?php

namespace hflan\LanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use hflan\UserBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Team
 *
 * @ORM\Table(name="hf_team")
 * @ORM\Entity(repositoryClass="hflan\LanBundle\Entity\TeamRepository")
 * @UniqueEntity(
 *      fields={"email", "event"},
 *      message="error.same_email.account"
 * )
 */
class Team
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     * @Gedmo\Slug(fields={"name"})
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="infoLocked", type="boolean")
     */
    private $infoLocked;

    /**
     * @var boolean
     *
     * @ORM\Column(name="paid", type="boolean")
     */
    private $paid;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var Tournament
     * @ORM\ManyToOne(targetEntity="Tournament", inversedBy="teams")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tournament;

    /**
     * @var Event
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="teams")
     * @ORM\JoinColumn(nullable=false)
     */
    private $event;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="hflan\UserBundle\Entity\User", inversedBy="teams")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(min = "3")
     */
    private $plainPassword;

    /**
     * @ORM\OneToMany(targetEntity="Player", mappedBy="team", cascade={"all"})
     */
    protected $players;

    public function __construct()
    {
        $this->setInfoLocked(false);
        $this->setPaid(false);
        $this->players = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
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
     * Set name
     *
     * @param string $name
     * @return Team
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Team
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set infoLocked
     *
     * @param boolean $infoLocked
     * @return Team
     */
    public function setInfoLocked($infoLocked)
    {
        $this->infoLocked = $infoLocked;
    
        return $this;
    }

    /**
     * Get infoLocked
     *
     * @return boolean 
     */
    public function getInfoLocked()
    {
        return $this->infoLocked;
    }

    /**
     * Set paid
     *
     * @param boolean $paid
     * @return Team
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;
    
        return $this;
    }

    /**
     * Get paid
     *
     * @return boolean 
     */
    public function getPaid()
    {
        return $this->paid;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Team
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set tournament
     *
     * @param Tournament $tournament
     * @return Team
     */
    public function setTournament(Tournament $tournament)
    {
        $this->tournament = $tournament;
        $this->event = $tournament->getEvent();
    
        return $this;
    }

    /**
     * Get tournament
     *
     * @return \hflan\LanBundle\Entity\Tournament 
     */
    public function getTournament()
    {
        return $this->tournament;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add player
     *
     * @param Player $player
     * @return Team
     */
    public function addPlayer(Player $player)
    {
        $this->players[] = $player;
    
        return $this;
    }

    /**
     * Remove player
     *
     * @param Player $player
     */
    public function removePlayer(Player $player)
    {
        $this->players->removeElement($player);
    }

    /**
     * Get players
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * @param Event $event
     */
    public function setEvent(Event $event)
    {
        $this->event = $event;
    }

    /**
     * @return Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    public function isValid()
    {
        foreach($this->getPlayers() as $player)
            if(!$player->isValid()) return false;

        return true;
    }
}