<?php

namespace App\Entity;

use App\Repository\PermissionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PermissionRepository::class)]
class Permission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $namePerm = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNamePerm(): ?string
    {
        return $this->namePerm;
    }

    public function setNamePerm(string $namePerm): static
    {
        $this->namePerm = $namePerm;

        return $this;
    }
}
