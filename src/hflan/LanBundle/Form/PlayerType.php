<?php

namespace hflan\LanBundle\Form;

use hflan\LanBundle\Entity\Player;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use hflan\LanBundle\Form\EventListener\RemovePcTypeFieldSubscriber;

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
                'label' => 'field.first_name',
            ))
            ->add('lastName', 'text', array(
                'label' => 'field.last_name',
            ))
            ->add('nickname', 'text', array(
                'label' => 'field.nickname',
            ))
            ->add('email', 'email', array(
                'label' => 'field.email',
            ))
            ->add('pcType', 'radiobar', array(
                'label' => 'field.computer_type',
                'choices' => array(
                    Player::PC_TYPE_DESKTOP => "field.computer.desktop",
                    Player::PC_TYPE_LAPTOP  => "field.computer.laptop",
                )
            ))
            ->add('birthday', 'birthday', array(
                'label' => 'field.birthday',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy'
            ))
        ;

        $builder->addEventSubscriber(new RemovePcTypeFieldSubscriber());
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
