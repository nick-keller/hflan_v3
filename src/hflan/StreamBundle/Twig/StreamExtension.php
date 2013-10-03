<?php
namespace hflan\StreamBundle\Twig;


use Doctrine\ORM\EntityManager;

class StreamExtension extends \Twig_Extension
{
    /**
     * @var EntityManager
     */
    private $em;

    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getFunctions()
    {
        return array(
            'countStreams' => new \Twig_Function_Method($this, 'countStreams'),
        );
    }

    public function countStreams()
    {
        return $this->em->getRepository('hflanStreamBundle:Stream')->count();
    }

    public function getName()
    {
        return 'hflan_stream';
    }
}