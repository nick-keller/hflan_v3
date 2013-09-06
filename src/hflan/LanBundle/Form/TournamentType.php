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
            ->add('gameType', 'text', array(
                'label' => 'Type de jeu',
                'attr' => array(
                    'placeholder' => 'Time-Attack, Team-Deathmatch, 2v2...'
                )
            ))
            ->add('numberOfTeams', 'number', array(
                'label' => "Nombre d'équipes"
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
