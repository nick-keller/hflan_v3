<?php

namespace hflan\BlockBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContext;

class BlockType extends AbstractType
{
    /** @var SecurityContext */
    private $securityContext;

    public function __construct(SecurityContext $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if($this->securityContext->isGranted('ROLE_ADMIN'))
            $builder
                ->add('slug', 'text', array(
                    'label' => 'Identifiant'
                ));

        $builder
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
