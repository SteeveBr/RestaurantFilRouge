<?php

namespace App\Entity;

use App\Repository\MenuCategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuCategoryRepository::class)]
class MenuCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'menuCategories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Menu $MenuId = null;

    #[ORM\ManyToOne(inversedBy: 'menuCategories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $CategoryId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMenuId(): ?Menu
    {
        return $this->MenuId;
    }

    public function setMenuId(?Menu $MenuId): static
    {
        $this->MenuId = $MenuId;

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
