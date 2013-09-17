<?php
namespace hflan\LanBundle\Entity\Export;


use Doctrine\Common\Collections\ArrayCollection;

class EventExport
{
    const LIST_PAID = 'paid';
    const LIST_LOCKED = 'locked';
    const LIST_BLANK = 'blank';

    /** @var  ArrayCollection */
    private $tournaments;

    private $lists;

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