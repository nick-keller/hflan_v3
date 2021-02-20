<?php

namespace hflan\LanBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TournamentType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'Nom'
            ))
            ->add('game', 'text', array(
                'label' => 'Nom du jeu'
            ))
            ->add('isConsole', 'toggle', array(
                'label' => 'Plateforme',
                'icons' => array(
                    'active' => 'gamepad',
                    'inactive' => 'desktop',
                ),
                'labels' => array(
                    'inactive' => 'Ordinateur',
                    'active' => 'Console',
                ),
                'required' => false,
            ))
            ->add('gameType', 'text', array(
                'label' => 'Type de matchs',
                'attr' => array(
                    'placeholder' => 'Time-Attack, Team-Deathmatch, 2v2...'
                )
            ))
            ->add('numberOfTeams', 'number', array(
                'label' => "Nombre d'équipes réel"
            ))
            ->add('numberOfVisibleTeams', 'number', array(
                'label' => "Nombre d'équipes à afficher"
            ))
            ->add('numberOfPlayerPerTeam', 'number', array(
                'label' => 'Joueur(s) / équipe'
            ))
            ->add('price', 'number', array(
                'label' => 'Prix'
            ))
            ->add('prizePoolInjection', 'number', array(
                'label' => 'Injection Prize-Pool'
            ))
            ->add('extraFields', 'collection', array(
                'label' => 'Champs spécifiques',
                'type' => 'extrafield',
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
            ->add('isPaymentOnTheSpot', 'toggle', array(
                'label' => 'Paiement sur place',
                'icons' => array(
                    'active'   => 'check-square-o',
                    'inactive' => 'square-o',
                ),
                'labels' => array(
                    'active'   => 'Oui',
                    'inactive' => 'Non',
                ),
                'required' => false,
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'hflan\LanBundle\Entity\Tournament'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'hflan_lanbundle_tournament';
    }
}
