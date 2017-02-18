<?php

namespace AccountBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', null, ['label' => 'Nom de l\'équipe'])
                ->add('resumptionDate', null, ['label' => 'Date de reprise'])
                ->add('trainingDay', null, ['label' => 'Jour d\'entrainement'])
                ->add('trainingTime', null, ['label' => 'Horaire d\'entrainement'])
                ->add('category', null, ['label' => 'Catégorie'])        
            ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AccountBundle\Entity\Team'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'accountbundle_team';
    }


}
