<?php

namespace AccountBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PersonType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('lastName', TextType::class, ['label' => 'Nom'])
                ->add('firstName', TextType::class, ['label' => 'Prénom'])
                ->add('email', EmailType::class);

        if (!$options['admin']) {
            $builder
                ->add('password', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'invalid_message' => 'Les champs de mot de passe doivent correspondre.',
                    'options' => array('attr' => array('class' => 'password-field')),
                    'required' => true,
                    'first_options' => ['label' => 'Mot de passe *'],
                    'second_options' => ['label' => 'Confirmer le mot de passe'],
                ]);
        }

        if ($options['admin']){
            $builder
                ->add('birthDate', null, ['label' => 'Date de naissance','years' => range(1900, date('Y'))])
                ->add('phone', null, ['label' => 'Téléphone'])
                ->add('street', null, ['label' => 'Rue'])
                ->add('zip', null, ['label' => 'Code Postal'])
                ->add('city', null, ['label' => 'Adresse'])
                ->add('teams', EntityType::class, [
                    'class' => 'AccountBundle:Team',
                    'label' => 'Equipes',
                    'multiple' => true,
                    'required' => false,
                ])
                ->add('userRoles', EntityType::class, [
                    'class' => 'AccountBundle:Role',
                    'label' => 'Roles',
                    'multiple' => true,
                    'required' => false,
                ]);
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults(array(
            'data_class' => 'AccountBundle\Entity\Person',
            'admin' => true
             ))
            ->setAllowedTypes('admin', 'bool');
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'accountbundle_person';
    }


}
