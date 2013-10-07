<?php

namespace hflan\BlockBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BlockType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('slug', 'text', array(
                'label' => 'Identifiant'
            ))
            ->add('textFr', 'ckeditor', array(
                'label' => 'Français'
            ))
            ->add('textEn', 'ckeditor', array(
                'label' => 'Anglais'
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'hflan\BlockBundle\Entity\Block'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'hflan_blockbundle_block';
    }
}
