<?php

namespace App\Form\Type;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EditType extends AbstractType
{
    protected $recalls;

    public function __construct()
    {
        $this->recalls = new ArrayCollection();
    }

    public function getRecalls(): Collection
    {
        return $this->recalls;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ["label" => 'Box name', 'attr' => ['class' => 'form-control']])
            ->add('list', CollectionType::class, [
                'label' => 'Recalls',
                'entry_type' => RecallType::class,
                'entry_options' => ['label' => false, 'attr' => ['class' => 'form-group']],
                'allow_add' => true,
                'by_reference' => false,
            ])
            ->add('save', SubmitType::class, ["label" => 'update', 'attr' => ['class' => 'btn btn-secondary']])
            ->add('exit', SubmitType::class, ["label" => 'exit', 'attr' => ['class' => 'btn btn-secondary']]);
    }
}