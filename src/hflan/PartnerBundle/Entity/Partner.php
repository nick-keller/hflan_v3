<?php

namespace hflan\PartnerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Partner
 *
 * @ORM\Table(name="hf_partner")
 * @ORM\Entity(repositoryClass="hflan\PartnerBundle\Entity\PartnerRepository")
 * @Gedmo\Uploadable(allowOverwrite = true, filenameGenerator = "SHA1")
 */
class Partner
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
     * @ORM\Column(name="text", type="string", length=255, nullable=true)
     */
    private $text;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Url()
     */
    private $url;

    /**
     * @var integer
     *
     * @Gedmo\SortablePosition
     * @ORM\Column(name="sort_index", type="integer")
     */
    private $sortIndex;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255, nullable=true)
     * @Gedmo\UploadableFilePath
     */
    private $path;

    /**
     * @Assert\File(
     *     maxSize="1M",
     *     mimeTypes = {"image/jpeg", "image/png"},
     *     mimeTypesMessage = "Ce fichier n'est pas une image",
     *     maxSizeMessage = "Fichier trop gros (1Mo max)"
     * )
     */
    private $file;


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
     * @return Partner
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
     * Set text
     *
     * @param string $text
     * @return Partner
     */
    public function setText($text)
    {
        $this->text = $text;
    
        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set sortIndex
     *
     * @param integer $sortIndex
     * @return Partner
     */
    public function setSortIndex($sortIndex)
    {
        $this->sortIndex = $sortIndex;
    
        return $this;
    }

    /**
     * Get sortIndex
     *
     * @return integer 
     */
    public function getSortIndex()
    {
        return $this->sortIndex;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Company
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Get web path
     *
     * @return string
     */
    public function getWebPath()
    {
        return preg_replace('#^.+\.\./www/(.+)$#', '$1', $this->getPath());
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }
}
