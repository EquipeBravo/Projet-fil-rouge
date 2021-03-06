<?php

namespace GalleryBundle\Form;

use GalleryBundle\Entity\File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Form\Extension\Core\Type\FileType as FileTypeForm;

class FileType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', null, ['label' => 'Nom du fichier'])
            ->add('type', null, ['label' => 'Type de fichier'])
            ->add('alt', null, ['label' => 'Balise alt'])
            ->add('team', null, ['label' => 'Equipe'])
            ->add('files', FileTypeForm::class, ['label' => 'Photo à ajouter', 'data_class' => null]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => File::class //'GalleryBundle\Entity\File'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gallerybundle_file';
    }


}
