<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $comment_tricks = null;

    #[ORM\Column(type:'datetime', options:['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $comment_created_at = null;

    #[ORM\ManyToOne(inversedBy: 'comment')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'comment')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tricks $tricks = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentTricks(): ?string
    {
        return $this->comment_tricks;
    }

    public function setCommentTricks(string $comment_tricks): self
    {
        $this->comment_tricks = $comment_tricks;

        return $this;
    }

    public function getCommentCreatedAt(): ?\DateTimeImmutable
    {
        return $this->comment_created_at;
    }

    public function setCommentCreatedAt(\DateTimeImmutable $comment_created_at): self
    {
        $this->comment_created_at = $comment_created_at;

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

    public function getTricks(): ?Tricks
    {
        return $this->tricks;
    }

    public function setTricks(?Tricks $tricks): self
    {
        $this->tricks = $tricks;

        return $this;
    }
}
