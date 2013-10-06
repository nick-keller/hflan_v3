<?php
namespace hflan\BlockBundle\Twig;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Templating\EngineInterface;

class BlockExtension extends \Twig_Extension
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var EngineInterface
     */
    protected $templating;

    protected $container;

    function __construct(EntityManager $em, $container)
    {
        $this->em = $em;
        $this->container = $container;
    }

    public function getFunctions()
    {
        return array(
            'renderBlock' => new \Twig_Function_Method($this, 'renderBlock', array('is_safe' => array('html'))),
        );
    }

    public function renderBlock($slug)
    {
        $this->templating = $this->container->get('templating');
        $block = $this->em->getRepository('hflanBlockBundle:Block')->findOneBySlug($slug);

        return $this->templating->render('hflanBlockBundle:Public:block.html.twig', array(
            'block' => $block,
        ));
    }

    public function getName()
    {
        return 'hflan_block';
    }
}