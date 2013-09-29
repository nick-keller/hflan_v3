<?php
namespace hflan\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RolesType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => array(
                'ROLE_GUESTBOOK' => 'Supprimer des messages du guestbook',
                'ROLE_NEWSER' => 'A/M des articles',
                'ROLE_PARTNER' => 'A/M des partenaires',
                'ROLE_USER_MANAGER' => 'A/M des utilisateurs',
                'ROLE_RESPO' => 'A/M des évènements et des tournois. Gérer les équipes',
                'ROLE_REMOVE' => '* Supprimer des objets SI l\'utilisateur a déjà le droit d\'en créer',
                'ROLE_ADMIN' => '* Tous les droits précédents + créer des Admin',
            ),
            'multiple' => true,
            'expanded' => true,
            'attr' => array(
                'class' => 'staked-checkboxes',
            )
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'roles';
    }
}