<?php

namespace App\Form\Type;

use App\Entity\Recall;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditDescriptionType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description',TextareaType::class,['label' => false, 'attr' => [ 'class' => 'form-control rec_edit']])
            ->add('save', SubmitType::class, ["label" => 'update', 'attr' => ['class' => 'btn btn-secondary']]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recall::class,
        ]);
    }
}