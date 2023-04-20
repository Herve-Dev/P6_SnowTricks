<?php

namespace App\Entity;

use App\Repository\TricksRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TricksRepository::class)]
class Tricks
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150, unique: true)]
    private ?string $tricks_name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $tricks_description = null;

    #[ORM\Column(type:'datetime', options:['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $tricks_created_at = null;

    #[ORM\ManyToOne(inversedBy: 'tricks')]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'tricks', targetEntity: CommentTricks::class)]
    private Collection $commentTricks;

    public function __construct()
    {
        $this->commentTricks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTricksName(): ?string
    {
        return $this->tricks_name;
    }

    public function setTricksName(string $tricks_name): self
    {
        $this->tricks_name = $tricks_name;

        return $this;
    }

    public function getTricksDescription(): ?string
    {
        return $this->tricks_description;
    }

    public function setTricksDescription(string $tricks_description): self
    {
        $this->tricks_description = $tricks_description;

        return $this;
    }

    public function getTricksCreatedAt(): ?\DateTimeImmutable
    {
        return $this->tricks_created_at;
    }

    public function setTricksCreatedAt(\DateTimeImmutable $tricks_created_at): self
    {
        $this->tricks_created_at = $tricks_created_at;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, CommentTricks>
     */
    public function getCommentTricks(): Collection
    {
        return $this->commentTricks;
    }

    public function addCommentTrick(CommentTricks $commentTrick): self
    {
        if (!$this->commentTricks->contains($commentTrick)) {
            $this->commentTricks->add($commentTrick);
            $commentTrick->setTricks($this);
        }

        return $this;
    }

    public function removeCommentTrick(CommentTricks $commentTrick): self
    {
        if ($this->commentTricks->removeElement($commentTrick)) {
            // set the owning side to null (unless already changed)
            if ($commentTrick->getTricks() === $this) {
                $commentTrick->setTricks(null);
            }
        }

        return $this;
    }
}
