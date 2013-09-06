<?php

namespace hflan\LanBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use hflan\LanBundle\Entity\Event;

/**
 * Tournament
 *
 * @ORM\Table(name="hf_tournament")
 * @ORM\Entity(repositoryClass="hflan\LanBundle\Entity\TournamentRepository")
 */
class Tournament
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
     * @ORM\Column(name="game", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $game;

    /**
     * @var string
     *
     * @ORM\Column(name="gameType", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $gameType;

    /**
     * @var integer
     *
     * @ORM\Column(name="numberOfTeams", type="integer")
     * @Assert\NotBlank()
     * @Assert\Type(type="integer", message="Veuillez rentrer un nombre entier")
     * @Assert\Range(
     *      min = 2,
     *      max = 128,
     *      minMessage = "Minimum 2 teams...",
     *      maxMessage = "Plus de 128 teams ça fait beaucoup..."
     * )
     */
    private $numberOfTeams;

    /**
     * @var integer
     *
     * @ORM\Column(name="numberOfPlayerPerTeam", type="integer")
     * @Assert\NotBlank()
     * @Assert\Type(type="integer", message="Veuillez rentrer un nombre entier")
     * @Assert\Range(
     *      min = 1,
     *      max = 64,
     *      minMessage = "Les jeux solo sont en réalité des jeux d'équipes... Avec 1 joueur par équipe",
     *      maxMessage = "Plus de 64 joueurs par team c'est abusé..."
     * )
     */
    private $numberOfPlayerPerTeam;

    /**
     * @var integer
     *
     * @ORM\Column(name="price", type="integer")
     * @Assert\NotBlank()
     * @Assert\Type(type="integer", message="Veuillez rentrer un nombre entier")
     * @Assert\Range(
     *      min = 0,
     *      max = 50,
     *      minMessage = "Le prix ne peut pas être négatif",
     *      maxMessage = "Plus de 50€ c'est abusé... Sachant que le prix de la place n'est pas compris"
     * )
     */
    private $price;

    /**
     * @var integer
     *
     * @ORM\Column(name="prizePoolInjection", type="integer")
     * @Assert\NotBlank()
     * @Assert\Type(type="integer", message="Veuillez rentrer un nombre entier")
     * @Assert\Range(
     *      min = 0,
     *      max = 1000,
     *      minMessage = "On ne peut pas injecter une somme négative",
     *      maxMessage = "Mais bien sûr..."
     * )
     */
    private $prizePoolInjection;

    /**
     * @var Event
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="tournaments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $event;

    /**
     * @ORM\OneToMany(targetEntity="ExtraField", mappedBy="tournament", cascade={"persist", "remove"})
     */
    protected $extraFields;

    public function __construct(Event $event = null)
    {
        $this->setName('Tournoi ');
        $this->setNumberOfPlayerPerTeam(1);
        $this->setNumberOfTeams(16);
        $this->setPrizePoolInjection(0);
        $this->extraFields = new ArrayCollection();

        if($event !== null)
            $this->setEvent($event);
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
     * @return Tournament
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
     * @return Tournament
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
     * Set game
     *
     * @param string $game
     * @return Tournament
     */
    public function setGame($game)
    {
        $this->game = $game;
    
        return $this;
    }

    /**
     * Get game
     *
     * @return string 
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * @param string $gameType
     */
    public function setGameType($gameType)
    {
        $this->gameType = $gameType;
    }

    /**
     * @return string
     */
    public function getGameType()
    {
        return $this->gameType;
    }

    /**
     * Set numberOfTeams
     *
     * @param integer $numberOfTeams
     * @return Tournament
     */
    public function setNumberOfTeams($numberOfTeams)
    {
        $this->numberOfTeams = (int) $numberOfTeams;
    
        return $this;
    }

    /**
     * Get numberOfTeams
     *
     * @return integer 
     */
    public function getNumberOfTeams()
    {
        return $this->numberOfTeams;
    }

    /**
     * Set numberOfPlayerPerTeam
     *
     * @param integer $numberOfPlayerPerTeam
     * @return Tournament
     */
    public function setNumberOfPlayerPerTeam($numberOfPlayerPerTeam)
    {
        $this->numberOfPlayerPerTeam = (int) $numberOfPlayerPerTeam;
    
        return $this;
    }

    /**
     * Get numberOfPlayerPerTeam
     *
     * @return integer 
     */
    public function getNumberOfPlayerPerTeam()
    {
        return $this->numberOfPlayerPerTeam;
    }

    /**
     * Set price
     *
     * @param integer $price
     * @return Tournament
     */
    public function setPrice($price)
    {
        $this->price = (int) $price;
    
        return $this;
    }

    /**
     * Get price
     *
     * @return integer 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrizePool()
    {
        return $this->price * $this->numberOfPlayerPerTeam * $this->numberOfTeams + $this->prizePoolInjection;
    }

    /**
     * Set prizePoolInjection
     *
     * @param integer $prizePoolInjection
     * @return Tournament
     */
    public function setPrizePoolInjection($prizePoolInjection)
    {
        $this->prizePoolInjection = (int) $prizePoolInjection;
    
        return $this;
    }

    /**
     * Get prizePoolInjection
     *
     * @return integer 
     */
    public function getPrizePoolInjection()
    {
        return $this->prizePoolInjection;
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

    /**
     * Add extraFields
     *
     * @param ExtraField $extraField
     * @return Tournament
     */
    public function addExtraField(ExtraField $extraField)
    {
        $extraField->setTournament($this);
        $this->extraFields[] = $extraField;
    
        return $this;
    }

    /**
     * Remove extraFields
     *
     * @param ExtraField $extraField
     */
    public function removeExtraField(ExtraField $extraField)
    {
        $this->extraFields->removeElement($extraField);
    }

    /**
     * Get extraFields
     *
     * @return Collection
     */
    public function getExtraFields()
    {
        return $this->extraFields;
    }
}