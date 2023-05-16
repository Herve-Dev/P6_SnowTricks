<?php

namespace App\Form;

use App\Entity\MediaTricks;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MediaTricksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('media_name', FileType::class, [
                'label' => 'Media',
                //'mapped' => true,
                'required' => true
            ])
            ->add('delete', ButtonType::class, [
                'label' => 'Supprimer',
                'attr' => ['class' => 'delete-media'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MediaTricks::class,
        ]);
    }
}
