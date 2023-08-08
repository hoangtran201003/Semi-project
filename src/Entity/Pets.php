<?php

namespace App\Entity;

use App\Repository\PetsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PetsRepository::class)]
class Pets
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $PetName = null;

    #[ORM\Column(length: 255)]
    private ?string $Age = null;

    #[ORM\Column(length: 255)]
    private ?string $Price = null;

    #[ORM\Column(length: 255)]
    private ?string $Sex = null;

    #[ORM\Column(length: 255)]
    private ?string $Image = null;

    #[ORM\ManyToOne(inversedBy: 'Pets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $Category = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPetName(): ?string
    {
        return $this->PetName;
    }

    public function setPetName(?string $PetName): static
    {
        $this->PetName = $PetName;

        return $this;
    }

    public function getAge(): ?string
    {
        return $this->Age;
    }

    public function setAge(string $Age): static
    {
        $this->Age = $Age;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->Price;
    }

    public function setPrice(string $Price): static
    {
        $this->Price = $Price;

        return $this;
    }

    public function getSex(): ?string
    {
        return $this->Sex;
    }

    public function setSex(string $Sex): static
    {
        $this->Sex = $Sex;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(string $Image): static
    {
        $this->Image = $Image;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->Category;
    }

    public function setCategory(?Category $Category): static
    {
        $this->Category = $Category;

        return $this;
    }
}
