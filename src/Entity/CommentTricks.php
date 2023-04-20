<?php

namespace App\Entity;

use App\Repository\CommentTricksRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentTricksRepository::class)]
class CommentTricks
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $comment_tricks = null;

    #[ORM\Column(type:'datetime', options:['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $comment_tricks_created_at = null;

    #[ORM\ManyToOne(inversedBy: 'commentTricks')]
    private ?tricks $tricks = null;

    #[ORM\ManyToOne(inversedBy: 'commentTricks')]
    private ?user $user = null;

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

    public function getCommentTricksCreatedAt(): ?\DateTimeImmutable
    {
        return $this->comment_tricks_created_at;
    }

    public function setCommentTricksCreatedAt(\DateTimeImmutable $comment_tricks_created_at): self
    {
        $this->comment_tricks_created_at = $comment_tricks_created_at;

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

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }
}
