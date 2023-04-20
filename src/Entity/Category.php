<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $category_tricks = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?tricks $tricks = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryTricks(): ?string
    {
        return $this->category_tricks;
    }

    public function setCategoryTricks(string $category_tricks): self
    {
        $this->category_tricks = $category_tricks;

        return $this;
    }

    public function getTricks(): ?tricks
    {
        return $this->tricks;
    }

    public function setTricks(?tricks $tricks): self
    {
        $this->tricks = $tricks;

        return $this;
    }
}
