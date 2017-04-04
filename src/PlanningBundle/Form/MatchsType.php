<?php

namespace PlanningBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AccountBundle\Entity\Team;
use AccountBundle\Repository\TeamRepository;

class MatchsType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dateMatch', null, ['label' => 'Date du match','years'=> range(2017, (date('Y')+5))])
                ->add('domicile')
                ->add('place', EntityType::class, [
                    'class' => 'PlanningBundle:Place',
                    'label' => 'Lieu'
                ])
                ->add('team', EntityType::class,  [
                    'class' => 'AccountBundle:Team',
                    'label' => 'Equipe'
                  ])
                ->add('team2', EntityType::class,  [
                    'class' => 'AccountBundle:Team',
                    'label' => 'Equipe adverse'
                  ])
            ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PlanningBundle\Entity\Matchs'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'planningbundle_matchs';
    }


}
