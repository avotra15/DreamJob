<?php

namespace App\Entity;

use App\Repository\CVRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CVRepository::class)]
class CV
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Vich\UploadableField(mapping: 'cv_files', fileNameProperty: 'Fichier')]
    #[Assert\File(
        maxSize: '1024k',
        extensions: ['pdf']
    )]
    private ?File $namecv = null;

    #[ORM\ManyToOne(inversedBy: 'cVs')]
    private ?Users $email_cand = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNamecv(): ?File
    {
        return $this->namecv;
    }

    public function setNamecv(File $namecv): static
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
