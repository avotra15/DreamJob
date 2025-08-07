<?php

namespace App\Form;

use App\Entity\JobDetails;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobDetailsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EntityType::class, [
                'class' => Users::class,
                'choice_label' => 'id',
            ])
            ->add('Fichier', FileType::class)
            ->add('Titre')
            ->add('Description')
            ->add('Logo', FileType::class)  
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => JobDetails::class,
        ]);
    }
}
