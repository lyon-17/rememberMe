<?php

namespace App\Entity;

use App\Repository\BoxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BoxRepository::class)]
class Box
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'target_box', targetEntity: Recall::class)]
    private $list;

    public function __construct()
    {
        $this->list = new ArrayCollection();
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

    /**
     * @return Collection<int, recall>
     */
    public function getList(): Collection
    {
        return $this->list;
    }

    public function addList(recall $list): self
    {
        if (!$this->list->contains($list)) {
            $this->list[] = $list;
            $list->setTargetBox($this);
        }

        return $this;
    }

    public function removeList(recall $list): self
    {
        if ($this->list->removeElement($list)) {
            // set the owning side to null (unless already changed)
            if ($list->getTargetBox() === $this) {
                $list->setTargetBox(null);
            }
        }

        return $this;
    }
}
