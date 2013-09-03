<?php
namespace hflan\LanBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DatepickerType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'date_widget' => 'single_text',
            'date_format' => 'dd/MM/yyyy',
        ));
    }

    public function getParent()
    {
        return 'datetime';
    }

    public function getName()
    {
        return 'datepicker';
    }
}