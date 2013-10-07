<?php

namespace hflan\GuestbookBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FeedbackType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nickname', 'text', array(
                'label' => 'field.nickname'
            ))
            ->add('rating', 'rating', array(
                'label' => 'field.rating'
            ))
            ->add('message', 'textarea', array(
                'label' => 'field.message'
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'hflan\GuestbookBundle\Entity\Feedback'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'hflan_guestbookbundle_feedback';
    }
}
