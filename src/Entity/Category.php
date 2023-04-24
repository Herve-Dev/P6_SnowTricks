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

    #[ORM\Column(length: 255)]
    private ?string $category_tricks = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Tricks::class)]
    private Collection $Tricks;

    public function __construct()
    {
        $this->Tricks = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Tricks>
     */
    public function getTricks(): Collection
    {
        return $this->Tricks;
    }

    public function addTrick(Tricks $trick): self
    {
        if (!$this->Tricks->contains($trick)) {
            $this->Tricks->add($trick);
            $trick->setCategory($this);
        }

        return $this;
    }

    public function removeTrick(Tricks $trick): self
    {
        if ($this->Tricks->removeElement($trick)) {
            // set the owning side to null (unless already changed)
            if ($trick->getCategory() === $this) {
                $trick->setCategory(null);
            }
        }

        return $this;
    }
}
