<?php

namespace hflan\LanBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ExtraFieldType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'Nom du champ'
            ))
            ->add('placeholder', 'text', array(
                'label' => 'Exemple de valeur',
                'required' => false,
            ))
            ->add('validator', 'textarea', array(
                'label' => 'Regex',
                'required' => false,
                'attr' => array(
                    'placeholder' => '#^[0-9]+$#'
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
            'data_class' => 'hflan\LanBundle\Entity\ExtraField'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'extrafield';
    }
}
