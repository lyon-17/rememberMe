<?php

namespace App\Form\Type;

use App\Repository\BoxRepository;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RecallType extends AbstractType
{
    private $boxRepository;

    function __construct(BoxRepository $boxRepository)
    {
        $this->boxRepository = $boxRepository;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $boxNames = $this->boxRepository->getBoxesName();
        
        $builder
            ->add('boxName', ChoiceType::class, [
            'label' => 'picker',
            'choices' => $boxNames,
            'choice_label' => function ($choice, $key, $value) {
                return $value;
            }])
            ->add('recall', SubmitType::class,["label" => 'add recall']);
    }
}