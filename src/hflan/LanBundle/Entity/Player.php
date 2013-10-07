<?php

namespace hflan\LanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Player
 *
 * @ORM\Table(name="hf_player")
 * @ORM\Entity(repositoryClass="hflan\LanBundle\Entity\PlayerRepository")
 * @UniqueEntity(
 *      fields={"email", "event"},
 *      message="error.same_email.user"
 * )
 * @UniqueEntity(
 *      fields={"nickname", "event"},
 *      message="error.same_nickname.user"
 * )
 */
class Player
{
    const PC_TYPE_DESKTOP = 'Desktop';
    const PC_TYPE_LAPTOP = 'Laptop';

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
     * @ORM\Column(name="firstName", type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(min = "2")
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(min = "2")
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="nickname", type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(min = "2")
     */
    private $nickname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="pcType", type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Choice(choices = {Player::PC_TYPE_DESKTOP, Player::PC_TYPE_LAPTOP})
     */
    private $pcType;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthday", type="datetime", nullable=true)
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    private $birthday;

    /**
     * @var array
     *
     * @ORM\Column(name="extraFields", type="array")
     */
    private $extraFields;

    /**
     * @var Team
     * @ORM\ManyToOne(targetEntity="Team", inversedBy="players")
     * @ORM\JoinColumn(nullable=false)
     */
    private $team;

    /**
     * @var Tournament
     * @ORM\ManyToOne(targetEntity="Tournament", inversedBy="players")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tournament;

    /**
     * @var Event
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="players")
     * @ORM\JoinColumn(nullable=false)
     */
    private $event;


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
     * Set firstName
     *
     * @param string $firstName
     * @return Player
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    
        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Player
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    
        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set nickname
     *
     * @param string $nickname
     * @return Player
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    
        return $this;
    }

    /**
     * Get nickname
     *
     * @return string 
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Player
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set pcType
     *
     * @param string $pcType
     * @return Player
     */
    public function setPcType($pcType)
    {
        $this->pcType = $pcType;
    
        return $this;
    }

    /**
     * Get pcType
     *
     * @return string 
     */
    public function getPcType()
    {
        return $this->pcType;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     * @return Player
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    
        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime 
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set extraFields
     *
     * @param array $extraFields
     * @return Player
     */
    public function setExtraFields($extraFields)
    {
        $this->extraFields = $extraFields;
    
        return $this;
    }

    /**
     * Get extraFields
     *
     * @return array 
     */
    public function getExtraFields()
    {
        return $this->extraFields;
    }

    /**
     * Set team
     *
     * @param Team $team
     * @return Player
     */
    public function setTeam(Team $team)
    {
        $this->team = $team;
    
        return $this;
    }

    /**
     * Get team
     *
     * @return Team
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Set tournament
     *
     * @param Tournament $tournament
     * @return Player
     */
    public function setTournament(Tournament $tournament)
    {
        $this->tournament = $tournament;
    
        return $this;
    }

    /**
     * Get tournament
     *
     * @return Tournament
     */
    public function getTournament()
    {
        return $this->tournament;
    }

    public function isValid()
    {
        return $this->getFirstName() != null;
    }

    public function isMinor()
    {
        if($this->birthday)
            return $this->birthday->diff(new \DateTime)->y < 18;
        return false;
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
}