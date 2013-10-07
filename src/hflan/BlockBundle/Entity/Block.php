<?php

namespace hflan\BlockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Block
 *
 * @ORM\Table(name="hf_block")
 * @ORM\Entity(repositoryClass="hflan\BlockBundle\Entity\BlockRepository")
 * @UniqueEntity("slug")
 */
class Block
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
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="text_fr", type="text")
     */
    private $textFr;

    /**
     * @var string
     *
     * @ORM\Column(name="text_en", type="text")
     */
    private $textEn;


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
     * Set slug
     *
     * @param string $slug
     * @return Block
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
     * Set text fr
     *
     * @param string $text
     * @return Block
     */
    public function setTextFr($text)
    {
        $this->textFr = $text;
    
        return $this;
    }

    /**
     * Get text fr
     *
     * @return string 
     */
    public function getTextFr()
    {
        return $this->textFr;
    }

    /**
     * Set text en
     *
     * @param string $text
     * @return Block
     */
    public function setTextEn($text)
    {
        $this->textEn = $text;

        return $this;
    }

    /**
     * Get text fr
     *
     * @return string
     */
    public function getTextEn()
    {
        return $this->textEn;
    }
}
