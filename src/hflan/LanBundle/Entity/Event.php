<?php

namespace hflan\LanBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContextInterface;
use hflan\LanBundle\Entity\Tournament;

/**
 * Event
 *
 * @ORM\Table(name="hf_event")
 * @ORM\Entity(repositoryClass="hflan\LanBundle\Entity\EventRepository")
 * @Assert\Callback(methods={"checkDates"})
 */
class Event
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
     * @var integer
     *
     * @ORM\Column(name="price", type="integer")
     * @Assert\NotBlank()
     * @Assert\Type(type="integer", message="Veuillez rentrer un nombre entier")
     * @Assert\Range(
     *      min = 0,
     *      max = 20,
     *      minMessage = "Le prix ne peut pas être négatif",
     *      maxMessage = "Plus de 20€ c'est abusé..."
     * )
     */
    private $price;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="begin_at", type="datetime")
     * @Assert\NotBlank()
     */
    private $beginAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_at", type="datetime")
     * @Assert\NotBlank()
     */
    private $endAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="registration_open_at", type="datetime")
     * @Assert\NotBlank()
     */
    private $registrationOpenAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="registration_close_at", type="datetime")
     * @Assert\NotBlank()
     */
    private $registrationCloseAt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="dates_visible", type="boolean")
     */
    private $datesVisible;

    /**
     * @var boolean
     *
     * @ORM\Column(name="registration_visible", type="boolean")
     */
    private $registrationVisible;

    /**
     * @ORM\OneToMany(targetEntity="Tournament", mappedBy="event", cascade={"remove"})
     */
    protected $tournaments;

    public function __construct()
    {
        $this->setBeginAt(new \Datetime());
        $this->beginAt->setTime(10, 0);
        $this->setEndAt(new \Datetime());
        $this->endAt->setTime(17, 0);
        $this->setRegistrationOpenAt(new \Datetime());
        $this->registrationOpenAt->setTime(10, 0);
        $this->setRegistrationCloseAt(new \Datetime());
        $this->registrationCloseAt->setTime(23, 59);
        $this->setName("hf.lan");
        $this->tournaments = new ArrayCollection();
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
     * @return Event
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
     * @return Event
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
     * Set price
     *
     * @param integer $price
     * @return Event
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
     * Set beginAt
     *
     * @param \DateTime $beginAt
     * @return Event
     */
    public function setBeginAt($beginAt)
    {
        $this->beginAt = $beginAt;
    
        return $this;
    }

    /**
     * Get beginAt
     *
     * @return \DateTime 
     */
    public function getBeginAt()
    {
        return $this->beginAt;
    }

    /**
     * Set endAt
     *
     * @param \DateTime $endAt
     * @return Event
     */
    public function setEndAt($endAt)
    {
        $this->endAt = $endAt;
    
        return $this;
    }

    /**
     * Get endAt
     *
     * @return \DateTime 
     */
    public function getEndAt()
    {
        return $this->endAt;
    }

    /**
     * Set registrationOpenAt
     *
     * @param \DateTime $registrationOpenAt
     * @return Event
     */
    public function setRegistrationOpenAt($registrationOpenAt)
    {
        $this->registrationOpenAt = $registrationOpenAt;
    
        return $this;
    }

    /**
     * Get registrationOpenAt
     *
     * @return \DateTime 
     */
    public function getRegistrationOpenAt()
    {
        return $this->registrationOpenAt;
    }

    /**
     * Set registrationCloseAt
     *
     * @param \DateTime $registrationCloseAt
     * @return Event
     */
    public function setRegistrationCloseAt($registrationCloseAt)
    {
        $this->registrationCloseAt = $registrationCloseAt;
    
        return $this;
    }

    /**
     * Get registrationCloseAt
     *
     * @return \DateTime 
     */
    public function getRegistrationCloseAt()
    {
        return $this->registrationCloseAt;
    }

    /**
     * Set datesVisible
     *
     * @param boolean $datesVisible
     * @return Event
     */
    public function setDatesVisible($datesVisible)
    {
        $this->datesVisible = $datesVisible;
    
        return $this;
    }

    /**
     * Get datesVisible
     *
     * @return boolean 
     */
    public function getDatesVisible()
    {
        return $this->datesVisible;
    }

    /**
     * Set registrationVisible
     *
     * @param boolean $registrationVisible
     * @return Event
     */
    public function setRegistrationVisible($registrationVisible)
    {
        $this->registrationVisible = $registrationVisible;
    
        return $this;
    }

    /**
     * Get registrationVisible
     *
     * @return boolean 
     */
    public function getRegistrationVisible()
    {
        return $this->registrationVisible;
    }

    public function checkDates(ExecutionContextInterface $context)
    {
        if($this->beginAt->diff($this->endAt)->invert === 1)
            $context->addViolationAt('endAt', "La date de fin de l'évènement ne peut pas être avant la date de début");

        if($this->registrationOpenAt->diff($this->registrationCloseAt)->invert === 1)
            $context->addViolationAt('registrationCloseAt', "La date de fermeture des inscriptions ne peut pas être avant la date d'ouverture");

        if($this->registrationCloseAt->diff($this->beginAt)->invert === 1)
            $context->addViolationAt('registrationCloseAt', "La date de fermeture des inscriptions ne peut pas être après le début de l'évènement");

        if($this->registrationVisible && !$this->datesVisible)
            $context->addViolationAt('registrationVisible', "Pour que les dates d'inscription sois public, les dates de l'évènement doivent l'être aussi");
    }

    /**
     * Add tournaments
     *
     * @param Tournament $tournaments
     * @return Event
     */
    public function addTournament(Tournament $tournaments)
    {
        $this->tournaments[] = $tournaments;

        return $this;
    }

    /**
     * Remove tournaments
     *
     * @param Tournament $tournaments
     */
    public function removeTournament(Tournament $tournaments)
    {
        $this->tournaments->removeElement($tournaments);
    }

    /**
     * Get tournaments
     *
     * @return Collection
     */
    public function getTournaments()
    {
        return $this->tournaments;
    }
}