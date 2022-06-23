<?php

namespace App\Form\Type;

use App\Entity\Status;
use App\Service\StatusHelper;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AddStatusType extends AbstractType
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
        ->add('priority', NumberType::class,['html5' => true, 'label' => 'priority', 'attr' => ['class' => 'form-control']])
        ->add('icon', ChoiceType::class, [
            'label' => 'Select icon',
            'choices' => $iconPicker,
        ])
        ->add('add',SubmitType::class,['label' => 'Add', 'attr' => ['class' => 'btn btn-secondary']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Status::class,
        ]);
    }

}