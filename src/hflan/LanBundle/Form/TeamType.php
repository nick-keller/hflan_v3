<?php

namespace hflan\LanBundle\Form;

use hflan\LanBundle\Entity\Event;
use hflan\LanBundle\Entity\TournamentRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TeamType extends AbstractType
{
    /** @var  Event */
    private $event;
    /** @var  boolean */
    private $onlyName;

    public function __construct(Event $event = null, $onlyName = false)
    {
        $this->event = $event;
        $this->onlyName = $onlyName;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => "field.team_name",
            ))
            ->add('tournament', 'entity', array(
                'label'         => "field.tournament",
                'class'         => 'hflan\LanBundle\Entity\Tournament',
                'query_builder' => function(TournamentRepository $repo) {
                    return $repo->queryTournamentsOfEvent($this->event);
                },
            ))
        ;
        if (!$this->onlyName) {
            $builder
                ->add('email', 'text', array(
                    'label' => "field.email",
                ))
                ->add('plainPassword', 'repeated', array(
                    'type'           => 'password',
                    'first_options'  => array('label' => "field.password"),
                    'second_options' => array('label' => "field.verification"),
                ))
            ;
        }
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'hflan\LanBundle\Entity\Team'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'hflan_lanbundle_team';
    }
}
