<?php

namespace App\Form;

use App\Entity\Note;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoteType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
    //champ input pour la note utilisateur
    ->add('viewerNote', ChoiceType::class,[
      'choices' => $this->createNoteChoices(),
      'label' => 'Note du spectateur',
      'attr' => ['class' => 'form-control mb-3']
    ])
    //champ input pour la note de la presse
    ->add('mediaNote', ChoiceType::class,[
      'choices' => $this->createNoteChoices(),
      'label' => 'Note de la presse',
      'attr' => ['class' => 'form-control mb-3']
    ]);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => Note::class,
      'attr' => ['class' => 'form']
    ]);
  }

  public function createNoteChoices():array
  {
    $choices = [];
    for($i = 0; $i <=20 ; $i++)
    {
      $choices[$i] = $i;
    }
    return $choices;
  }
}