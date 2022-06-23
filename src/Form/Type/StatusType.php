<?php

namespace App\Form\Type;

use App\Entity\Status;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;


class StatusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name',TextType::class,['label' => 'name', 'attr' => ['class' => 'form-control']])
        ->add('priority', NumberType::class,['label' => 'set priority', 'attr' => ['class' => 'form-control']])
        ->add('save',SubmitType::class,['label' => 'modify', 'attr' => ['class' => 'btn btn-secondary']])
        ->add('exit',SubmitType::class,['label' => 'return', 'attr' => ['class' => 'btn btn-secondary']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Status::class,
        ]);
    }

}