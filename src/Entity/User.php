<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(type:'datetime', options:['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $user_created_at = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Tricks::class)]
    private Collection $tricks;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: CommentTricks::class)]
    private Collection $commentTricks;

    public function __construct()
    {
        $this->tricks = new ArrayCollection();
        $this->commentTricks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getUserCreatedAt(): ?\DateTimeImmutable
    {
        return $this->user_created_at;
    }

    public function setUserCreatedAt(\DateTimeImmutable $user_created_at): self
    {
        $this->user_created_at = $user_created_at;

        return $this;
    }

    /**
     * @return Collection<int, Tricks>
     */
    public function getTricks(): Collection
    {
        return $this->tricks;
    }

    public function addTrick(Tricks $trick): self
    {
        if (!$this->tricks->contains($trick)) {
            $this->tricks->add($trick);
            $trick->setUser($this);
        }

        return $this;
    }

    public function removeTrick(Tricks $trick): self
    {
        if ($this->tricks->removeElement($trick)) {
            // set the owning side to null (unless already changed)
            if ($trick->getUser() === $this) {
                $trick->setUser(null);
            }
        }

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
            $commentTrick->setUser($this);
        }

        return $this;
    }

    public function removeCommentTrick(CommentTricks $commentTrick): self
    {
        if ($this->commentTricks->removeElement($commentTrick)) {
            // set the owning side to null (unless already changed)
            if ($commentTrick->getUser() === $this) {
                $commentTrick->setUser(null);
            }
        }

        return $this;
    }
}
