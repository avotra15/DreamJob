<?php

namespace App\Entity;

use App\Repository\CVRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CVRepository::class)]
class CV
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $namecv = null;

    #[ORM\ManyToOne(inversedBy: 'cVs')]
    private ?Users $email_cand = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNamecv(): ?string
    {
        return $this->namecv;
    }

    public function setNamecv(string $namecv): static
    {
        $this->namecv = $namecv;

        return $this;
    }

    public function getEmailCand(): ?Users
    {
        return $this->email_cand;
    }

    public function setEmailCand(?Users $email_cand): static
    {
        $this->email_cand = $email_cand;

        return $this;
    }
}
