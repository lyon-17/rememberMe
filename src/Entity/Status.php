<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatusRepository::class)]
class Status
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'integer')]
    private $priority;

    #[ORM\OneToMany(mappedBy: 'state', targetEntity: Recall::class)]
    private $status_name;

    public function __construct()
    {
        $this->status_name = new ArrayCollection();
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

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @return Collection<int, Recall>
     */
    public function getStatusName(): Collection
    {
        return $this->status_name;
    }

    public function addStatusName(Recall $statusName): self
    {
        if (!$this->status_name->contains($statusName)) {
            $this->status_name[] = $statusName;
            $statusName->setState($this);
        }

        return $this;
    }

    public function removeStatusName(Recall $statusName): self
    {
        if ($this->status_name->removeElement($statusName)) {
            // set the owning side to null (unless already changed)
            if ($statusName->getState() === $this) {
                $statusName->setState(null);
            }
        }

        return $this;
    }
}
