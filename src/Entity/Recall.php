<?php

namespace App\Entity;

use App\Repository\RecallRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecallRepository::class)]
class Recall
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\ManyToOne(targetEntity: Box::class, inversedBy: 'list')]
    private $target_box;
    
    #[ORM\Column(type: 'string', length: 255, nullable: true, options:["default" => "progress"])]
    private $status;

    private $boxName;

    #[ORM\ManyToOne(targetEntity: Status::class, inversedBy: 'status_name')]
    private $state;


    public function getBoxName(): ?string
    {
        return $this->boxName;
    }

    public function setBoxName(string $boxName): self
    {
        $this->boxName = $boxName;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTargetBox(): ?Box
    {
        return $this->target_box;
    }

    public function setTargetBox(?Box $target_box): self
    {
        $this->target_box = $target_box;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getState(): ?Status
    {
        return $this->state;
    }

    public function setState(?Status $state): self
    {
        $this->state = $state;

        return $this;
    }
}
