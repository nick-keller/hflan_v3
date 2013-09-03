<?php

namespace hflan\LanBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EventType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'Nom'
            ))
            ->add('price', 'number', array(
                'label' => 'Prix'
            ))
            ->add('beginAt', 'datepicker', array(
                'label' => 'Début'
            ))
            ->add('endAt', 'datepicker', array(
                'label' => 'Fin'
            ))
            ->add('datesVisible', 'toggle', array(
                'label' => 'Visibilité',
                'icons' => array(
                    'active' => 'eye-open',
                    'inactive' => 'eye-close',
                ),
                'labels' => array(
                    'inactive' => 'Caché',
                    'active' => 'Public',
                ),
                'required' => false,
            ))
            ->add('registrationOpenAt', 'datepicker', array(
                'label' => 'Ouverture'
            ))
            ->add('registrationCloseAt', 'datepicker', array(
                'label' => 'Fermeture'
            ))
            ->add('registrationVisible', 'toggle', array(
                'label' => 'Visibilité',
                'icons' => array(
                    'active' => 'eye-open',
                    'inactive' => 'eye-close',
                ),
                'labels' => array(
                    'inactive' => 'Caché',
                    'active' => 'Public',
                ),
                'required' => false,
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'hflan\LanBundle\Entity\Event'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'hflan_lanbundle_event';
    }
}
