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
                'ROLE_STREAM' => 'Ajouter, modifier et supprimer des stream',
                'ROLE_BLOCK' => 'Modifier les pages du site',
                'ROLE_NEWSER' => 'Ajouter et modifier des articles',
                'ROLE_PARTNER' => 'Ajouter et modifier des partenaires',
                'ROLE_USER_MANAGER' => 'Ajouter et modifier des utilisateurs',
                'ROLE_RESPO' => 'Ajouter et modifier des évènements et des tournois. Gérer les équipes',
                'ROLE_REMOVE' => '<i class="icon-asterisk"></i> Supprimer des objets SI l\'utilisateur a déjà le droit d\'en créer',
                'ROLE_ADMIN' => '<i class="icon-asterisk"></i> Tous les droits précédents + créer des Admin',
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