<?php

namespace App\Entity;

use App\Repository\JobDetailsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: JobDetailsRepository::class)]
#[Vich\Uploadable()]
class JobDetails
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Fichier = null;

    #[Vich\UploadableField(mapping: 'job_files', fileNameProperty: 'Fichier')]
    #[Assert\File()]
    private ?File $FichierFile = null;

    #[ORM\ManyToOne(inversedBy: 'jobDetails')]
    private ?Users $email = null;

    #[ORM\Column(length: 255)]
    private ?string $Titre = null;

    #[ORM\Column(length: 500)]
    private ?string $Description = null;

    #[ORM\Column(length: 255)]
    private ?string $Logo = null;

    #[Vich\UploadableField(mapping: 'job_logos', fileNameProperty: 'Logo')]
    #[Assert\Image()]
    private ?File $LogoFile = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFichier(): ?string
    {
        return $this->Fichier;
    }

    public function setFichier(?string $Fichier): static
    {
        $this->Fichier = $Fichier;

        return $this;
    }

    public function getFichierFile(): ?File
    {
        return $this->FichierFile;
    }

    public function setFichierFile(?File $FichierFile = null): static
    {
        $this->FichierFile = $FichierFile;

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

    public function getLogo(): ?string
    {
        return $this->Logo;
    }

    public function setLogo(?string $Logo): static
    {
        $this->Logo = $Logo;

        return $this;
    }

    public function getLogoFile(): ?File
    {
        return $this->LogoFile;
    }

    public function setLogoFile(?File $LogoFile = null): static
    {
        $this->LogoFile = $LogoFile;

        return $this;
    }
}
