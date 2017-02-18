<?php

namespace AccountBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class PersonType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('lastName', null, ['label' => 'Nom'])
                ->add('firstName', null, ['label' => 'Prénom'])
                ->add('birthDate', null, ['label' => 'Date de naissance'])
                ->add('phone', null, ['label' => 'Téléphone'])
                ->add('street', null, ['label' => 'Rue'])
                ->add('zip', null, ['label' => 'Code Postal'])
                ->add('city', null, ['label' => 'Adresse'])
                ->add('email', EmailType::class)
                ->add('password', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'first_options'  => ['label' => 'Mot de passe'],
                    'second_options' => ['label' => 'Confirmer le mot de passe']
                    ,])
                ->add('teams', null, ['label' => 'Equipes'])
                ->add('roles', null, ['label' => 'Roles'])        
            ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AccountBundle\Entity\Person'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'accountbundle_person';
    }


}
