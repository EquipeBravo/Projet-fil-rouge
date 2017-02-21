<?php

namespace PlanningBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class MatchsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dateMatch', null, ['label' => 'Date du match'])
                ->add('domicile')
                ->add('place', null, ['label' => 'Lieu'])   
                //->add('team', null, [
                  //  'data_class'=>'AccountBundle\Entity\Team',
                    //'choices' => 'displayName',
                    //])     
    //             ('users', EntityType::class, array(
    // // query choices from this entity
    // 'class' => 'AppBundle:User',
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
