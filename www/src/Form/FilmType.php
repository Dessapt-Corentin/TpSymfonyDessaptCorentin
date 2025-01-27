<?php

namespace App\Form;

use App\Entity\Age;
use App\Entity\Film;
use App\Entity\Genre;
use App\Entity\Note;
use App\Entity\Personne;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('synopsis')
            ->add('dateSortie', null, [
                'widget' => 'single_text',
            ])
            ->add('imagePath')
            ->add('time')
            ->add('genre', EntityType::class, [
                'class' => Genre::class,
                'choice_label' => 'label',
                'multiple' => true,
            ])
            ->add('age', EntityType::class, [
                'class' => Age::class,
                'choice_label' => 'label',
            ])
            ->add('prod', EntityType::class, [
                'class' => Personne::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('note', EntityType::class, [
                'class' => Note::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Film::class,
        ]);
    }
}
