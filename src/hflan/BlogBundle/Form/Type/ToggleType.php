<?php
namespace hflan\BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class ToggleType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'icons' => array(
                'inactive' => 'check-empty',
                'active' => 'check',
            ),
            'labels' => array(
                'inactive' => '',
                'active' => '',
            ),
        ));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        $view->vars = array_replace($view->vars, array(
            'icon_inactive' => $options['icons']['inactive'],
            'icon_active' => $options['icons']['active'],
            'label_inactive' => $options['labels']['inactive'],
            'label_active' => $options['labels']['active'],
        ));
    }

    public function getParent()
    {
        return 'checkbox';
    }

    public function getName()
    {
        return 'toggle';
    }
}