<?php
namespace hflan\LanBundle\Form\EventListener;

use hflan\LanBundle\Entity\Player;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RemovePcTypeFieldSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(FormEvents::PRE_SET_DATA => 'preSetData');
    }

    public function preSetData(FormEvent $event)
    {
        /** @var Player $data */
        $data = $event->getData();
        $form = $event->getForm();

        if ($data->getTournament()->getIsConsole()) {
            $form->remove('pcType');
        }
    }
}