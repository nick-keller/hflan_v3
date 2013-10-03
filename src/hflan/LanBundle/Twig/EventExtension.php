<?php
namespace hflan\LanBundle\Twig;


use Doctrine\ORM\EntityManager;
use hflan\LanBundle\Entity\Event;

class EventExtension extends \Twig_Extension
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var Event
     */
    private $nextEvent = 0;

    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getFunctions()
    {
        return array(
            'nextEvent' => new \Twig_Function_Method($this, 'nextEvent'),
        );
    }

    public function nextEvent()
    {
        if($this->nextEvent === 0)
            $this->nextEvent = $this->em->getRepository('hflanLanBundle:Event')->findNextEvent();

        return $this->nextEvent;
    }

    public function getName()
    {
        return 'hflan_event';
    }
}