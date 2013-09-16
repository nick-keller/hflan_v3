<?php
namespace hflan\LanBundle\Entity\Export;


use Doctrine\Common\Collections\ArrayCollection;
use hflan\LanBundle\Entity\Event;

class EventExport
{
    const LIST_PAID = 'paid';
    const LIST_LOCKED = 'locked';
    const LIST_BLANK = 'blank';

    /** @var  Event */
    private $event;

    /** @var  ArrayCollection */
    private $tournaments;

    private $lists;

    function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * @param Event $event
     */
    public function setEvent($event)
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
     * @param mixed $lists
     */
    public function setLists($lists)
    {
        $this->lists = $lists;
    }

    /**
     * @return mixed
     */
    public function getLists()
    {
        return $this->lists;
    }

    /**
     * @param ArrayCollection $tournaments
     */
    public function setTournaments(ArrayCollection $tournaments)
    {
        $this->tournaments = $tournaments;
    }

    /**
     * @return ArrayCollection
     */
    public function getTournaments()
    {
        return $this->tournaments;
    }
}