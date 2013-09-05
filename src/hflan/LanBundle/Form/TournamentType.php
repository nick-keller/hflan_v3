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
            ->add('numberOfTeams', 'text', array(
                'label' => "Nombre d'équipes"
            ))
            ->add('numberOfPlayerPerTeam', 'text', array(
                'label' => 'Joueur(s) / équipe'
            ))
            ->add('price', 'text', array(
                'label' => 'Prix'
            ))
            ->add('prizePoolInjection', 'text', array(
                'label' => 'Injection Prize-Pool'
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
