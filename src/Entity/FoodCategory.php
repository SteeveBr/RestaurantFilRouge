<?php

namespace App\Entity;

use App\Repository\FoodCategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FoodCategoryRepository::class)]
class FoodCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'foodCategories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Food $FoodId = null;

    #[ORM\ManyToOne(inversedBy: 'foodCategories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $CategoryId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFoodId(): ?Food
    {
        return $this->FoodId;
    }

    public function setFoodId(?Food $FoodId): static
    {
        $this->FoodId = $FoodId;

        return $this;
    }

    public function getCategoryId(): ?Category
    {
        return $this->CategoryId;
    }

    public function setCategoryId(?Category $CategoryId): static
    {
        $this->CategoryId = $CategoryId;

        return $this;
    }
}
