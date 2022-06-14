<?php

namespace App\Form\Type;

use App\Repository\BoxRepository;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CreateType extends AbstractType
{
    private $boxRepository;

    function __construct(BoxRepository $boxRepository)
    {
        $this->boxRepository = $boxRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $boxNames = $this->boxRepository->getBoxesName();

        $builder
            ->add('name', TextType::class)
            ->add('new', SubmitType::class, ["label" => 'create new box'])
            ->add('boxName', ChoiceType::class, [
            'label' => 'Select box',
            'choices' => $boxNames,
            'choice_label' => function ($choice, $key, $value) {
                return $value;
            }]
            )
            ->add('recall', SubmitType::class,["label" => 'add recall']);
    }

}