<?php

namespace hflan\LanBundle\Form\Export;

use hflan\LanBundle\Entity\Event;
use hflan\LanBundle\Entity\Export\EventExport;
use hflan\LanBundle\Entity\TournamentRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EventExportType extends AbstractType
{
    /** @var  Event */
    private $event;

    function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $event = $this->event;
        $builder
            ->add('tournaments', 'entity', array(
                'label' => 'Tournois',
                'expanded' => true,
                'multiple' => true,
                'class'=>'hflanLanBundle:Tournament',
                'query_builder' => function(TournamentRepository $er) use(&$event) {
                    return $er->queryTournamentsOfEvent($event);
                },
                'attr' => array(
                    'class' => 'staked-checkboxes',
                )
            ))
            ->add('lists', 'choice', array(
                'label' => 'Equipes',
                'expanded' => true,
                'multiple' => true,
                'choices' => array(
                    EventExport::LIST_BLANK => 'Pré-inscrites',
                    EventExport::LIST_LOCKED => 'En attente de paiement',
                    EventExport::LIST_PAID => 'Liste définitive',
                ),
                'attr' => array(
                    'class' => 'staked-checkboxes',
                )
            ))
            ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'hflan\LanBundle\Entity\Export\EventExport'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'hflan_lanbundle_event_export';
    }
}
