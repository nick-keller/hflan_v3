<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nico
 * Date: 21/09/13
 * Time: 20:29
 * To change this template use File | Settings | File Templates.
 */

namespace hflan\GuestbookBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RatingType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'expanded' => true,
            'attr' => array(
                'class' => 'rating-widget',
            ),
            'choices' => array(
                1 => '1',
                2 => '2',
                3 => '3',
                4 => '4',
                5 => '5',
            )
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'rating';
    }
}