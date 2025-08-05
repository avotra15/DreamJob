<?php

namespace App\Entity;

use App\Repository\JobDetailsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[ORM\Entity(repositoryClass: JobDetailsRepository::class)]
class JobDetails
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?UploadedFile $Fichier = null;

    #[ORM\ManyToOne(inversedBy: 'Email')]
    private ?Users $email = null;

    #[ORM\Column(length: 255)]
    private ?string $Titre = null;

    #[ORM\Column(length: 500)]
    private ?string $Description = null;

    #[ORM\Column(length: 255)]
    private ?UploadedFile $Logo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFichier(): ?UploadedFile
    {
        return $this->Fichier;
    }

    public function setFichier(?UploadedFile $Fichier): static
    {
        $this->Fichier = $Fichier;

        return $this;
    }

    public function getEmail(): ?Users
    {
        return $this->email;
    }

    public function setEmail(?Users $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->Titre;
    }

    public function setTitre(string $Titre): static
    {
        $this->Titre = $Titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function getLogo(): ?UploadedFile
    {
        return $this->Logo;
    }

    public function setLogo(?UploadedFile $Logo): static
    {
        $this->Logo = $Logo;

        return $this;
    }
}
