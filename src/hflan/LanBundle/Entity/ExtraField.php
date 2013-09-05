<?php

namespace hflan\LanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExtraField
 *
 * @ORM\Table(name="hf_extra_field")
 * @ORM\Entity(repositoryClass="hflan\LanBundle\Entity\ExtraFieldRepository")
 */
class ExtraField
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
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="placeholder", type="string", length=255)
     */
    private $placeholder;

    /**
     * @var string
     *
     * @ORM\Column(name="validator", type="string", length=255)
     */
    private $validator;

    /**
     * @var Tournament
     * @ORM\ManyToOne(targetEntity="Tournament", inversedBy="extraFields")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tournament;


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
     * @return ExtraField
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
     * @param string $placeholder
     */
    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;
    }

    /**
     * @return string
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * Set validator
     *
     * @param string $validator
     * @return ExtraField
     */
    public function setValidator($validator)
    {
        $this->validator = $validator;
    
        return $this;
    }

    /**
     * Get validator
     *
     * @return string 
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * Set tournament
     *
     * @param Tournament $tournament
     * @return ExtraField
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
}