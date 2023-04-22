<?php

namespace App\Entity;

use App\Repository\ImgTricksRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImgTricksRepository::class)]
class ImgTricks
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $img1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $video_tricks = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?tricks $tricks = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImg1(): ?string
    {
        return $this->img1;
    }

    public function setImg1(string $img1): self
    {
        $this->img1 = $img1;

        return $this;
    }

    public function getImg2(): ?string
    {
        return $this->img2;
    }

    public function setImg2(?string $img2): self
    {
        $this->img2 = $img2;

        return $this;
    }

    public function getImg3(): ?string
    {
        return $this->img3;
    }

    public function setImg3(?string $img3): self
    {
        $this->img3 = $img3;

        return $this;
    }

    public function getImg4(): ?string
    {
        return $this->img4;
    }

    public function setImg4(?string $img4): self
    {
        $this->img4 = $img4;

        return $this;
    }

    public function getVideoTricks(): ?string
    {
        return $this->video_tricks;
    }

    public function setVideoTricks(?string $video_tricks): self
    {
        $this->video_tricks = $video_tricks;

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
