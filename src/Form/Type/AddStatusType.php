<?php

namespace App\Form\Type;

use App\Entity\Status;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AddStatusType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name',TextType::class,['label' => 'name', 'attr' => ['class' => 'form-control']])
        ->add('priority', NumberType::class,['html5' => true, 'label' => 'priority', 'attr' => ['class' => 'form-control']])
        ->add('add',SubmitType::class,['label' => 'Add', 'attr' => ['class' => 'btn btn-secondary']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Status::class,
        ]);
    }

}