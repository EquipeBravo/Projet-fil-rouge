<?php

namespace AccountBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Validator\Constraints\DateTime;

class TeamType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', null, ['label' => 'Nom de l\'équipe'])
                ->add('resumptionDate', null, ['label' => 'Date de reprise'])
                ->add('trainingDay', null, ['label' => "Date d'entrainement"])
                ->add('category', null, ['label' => 'Catégorie'])
                ->add('coach', null, ['label' => 'Entraineur'])
                ->add('club', null, ['label' => 'Club'])
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
