<?php
namespace hflan\BlockBundle\Twig;


use Doctrine\ORM\EntityManager;

class BlockExtension extends \Twig_Extension
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
            'renderBlock' => new \Twig_Function_Method($this, 'renderBlock'),
        );
    }

    public function renderBlock($block)
    {
        return $this->em->getRepository('hflanBlockBundle:Block')->findOneBySlug($block)->getText();
    }

    public function getName()
    {
        return 'hflan_block';
    }
}