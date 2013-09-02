<?php

namespace hflan\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'label' => 'Titre',
            ))
            ->add('content', 'ckeditor', array(
                'label' => 'Article',
            ))
            ->add('published', 'toggle', array(
                'label' => 'Visibilité',
                'icons' => array(
                    'active' => 'eye-open',
                    'inactive' => 'eye-close',
                ),
                'labels' => array(
                    'inactive' => 'Chaché',
                    'active' => 'Public',
                ),
            ))
            ->add('lang', 'radiobar', array(
                'label' => 'Langue',
                'choices' => array(
                    'fr' => "francçais",
                    'en' => "english",
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
            'data_class' => 'hflan\BlogBundle\Entity\Article'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'hflan_blogbundle_article';
    }
}
