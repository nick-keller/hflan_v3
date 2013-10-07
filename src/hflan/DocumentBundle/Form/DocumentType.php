<?php

namespace hflan\DocumentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DocumentType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'Nom',
            ))
            ->add('text', 'ckeditor', array(
                'label' => 'Description',
            ))
            ->add('lang', 'radiobar', array(
                'label' => 'Langue',
                'choices' => array(
                    'fr' => "français",
                    'en' => "english",
                )
            ))
            ->add('file', 'file', array(
                'label' => 'Document pdf',
                'required' => false,
            ));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'hflan\DocumentBundle\Entity\Document'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'hflan_documentbundle_document';
    }
}
