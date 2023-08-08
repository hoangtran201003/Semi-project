<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $CateName = null;

    #[ORM\OneToMany(mappedBy: 'Category', targetEntity: Pets::class)]
    private Collection $Pets;

    public function __construct()
    {
        $this->Pets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCateName(): ?string
    {
        return $this->CateName;
    }

    public function setCateName(?string $CateName): static
    {
        $this->CateName = $CateName;

        return $this;
    }

    /**
     * @return Collection<int, Pets>
     */
    public function getPets(): Collection
    {
        return $this->Pets;
    }

    public function addPet(Pets $pet): static
    {
        if (!$this->Pets->contains($pet)) {
            $this->Pets->add($pet);
            $pet->setCategory($this);
        }

        return $this;
    }

    public function removePet(Pets $pet): static
    {
        if ($this->Pets->removeElement($pet)) {
            // set the owning side to null (unless already changed)
            if ($pet->getCategory() === $this) {
                $pet->setCategory(null);
            }
        }

        return $this;
    }
}
