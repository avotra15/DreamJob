<?php

namespace App\Entity;

use App\Repository\PermissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @var Collection<int, Users>
     */
    #[ORM\ManyToMany(targetEntity: Users::class, mappedBy: 'permission')]
    private Collection $users;

    #[ORM\Column(length: 500)]
    private ?string $description = null;

    /**
     * @var Collection<int, Roles>
     */
    #[ORM\ManyToMany(targetEntity: Roles::class, inversedBy: 'permissions')]
    private Collection $idRole;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->idRole = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Users>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(Users $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addPermission($this);
        }

        return $this;
    }

    public function removeUser(Users $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removePermission($this);
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Roles>
     */
    public function getIdRole(): Collection
    {
        return $this->idRole;
    }

    public function addIdRole(Roles $idRole): static
    {
        if (!$this->idRole->contains($idRole)) {
            $this->idRole->add($idRole);
        }

        return $this;
    }

    public function removeIdRole(Roles $idRole): static
    {
        $this->idRole->removeElement($idRole);

        return $this;
    }
}
