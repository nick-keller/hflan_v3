<?php
namespace hflan\LanBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class DatepickerType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'date_widget' => 'single_text',
            'date_format' => 'dd/MM/yyyy',
            'show_time' => true,
        ));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        $view->vars = array_replace($view->vars, array(
            'show_time' => $options['show_time'],
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