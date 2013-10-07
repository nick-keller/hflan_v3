<?php
namespace hflan\BlockBundle\Twig;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Translation\Translator;

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

    /** @var  Translator */
    private $translator;

    private $locale;

    protected $container;

    function __construct(EntityManager $em, Translator $translator, $container)
    {
        $this->em = $em;
        $this->translator = $translator;
        $this->locale = $this->translator->getLocale();
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
            'html' => $this->locale == 'en' ? $block->getTextEn() : $block->getTextFr(),
        ));
    }

    public function getName()
    {
        return 'hflan_block';
    }
}