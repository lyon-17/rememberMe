<?php

namespace App\Form\Type;

use App\Entity\Status;
use App\Service\StatusHelper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;


class StatusType extends AbstractType
{
    private $statusHelper;

    public function __construct(StatusHelper $statusHelper)
    {
        $this->statusHelper = $statusHelper;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $iconPicker = $this->statusHelper->generatePicker();

        $builder
        ->add('name',TextType::class,['label' => 'name', 'attr' => ['class' => 'form-control']])
        ->add('priority', NumberType::class,['label' => 'set priority', 'attr' => ['class' => 'form-control']])
        ->add('icon', ChoiceType::class, [
            'label' => 'Select icon',
            'choices' => $iconPicker,
        ])
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