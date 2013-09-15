<?php

namespace hflan\LanBundle\Form;

use hflan\LanBundle\Entity\Player;
use hflan\LanBundle\Form\EventListener\AddExtraFieldsSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlayerType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', 'text', array(
                'label' => 'Prénom',
            ))
            ->add('lastName', 'text', array(
                'label' => 'Nom de famille',
            ))
            ->add('nickname', 'text', array(
                'label' => 'Pseudo',
            ))
            ->add('email', 'email', array(
                'label' => 'Email',
            ))
            ->add('pcType', 'radiobar', array(
                'label' => 'Ordinateur',
                'choices' => array(
                    Player::PC_TYPE_DESKTOP => "PC Fix",
                    Player::PC_TYPE_LAPTOP  => "PC Portable",
                )
            ))
            ->add('birthday', 'datepicker', array(
                'label' => 'Date de naissance',
                'show_time' => false,
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'hflan\LanBundle\Entity\Player'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'hflan_lanbundle_player';
    }
}
