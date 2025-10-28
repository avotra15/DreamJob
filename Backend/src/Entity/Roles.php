<?php

namespace App\Entity;

use App\Repository\RolesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RolesRepository::class)]
class Roles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $role = null;

    /**
     * @var Collection<int, Users>
     */
    #[ORM\ManyToMany(targetEntity: Users::class, mappedBy: 'roles')]
    private Collection $users;

    /**
     * @var Collection<int, PagePerm>
     */
    #[ORM\ManyToMany(targetEntity: PagePerm::class, mappedBy: 'id_role')]
    private Collection $pagePerms;


    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->pagePerms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;
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
            $user->addRole($this);
        }
        return $this;
    }

    public function removeUser(Users $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeRole($this);
        }
        return $this;
    }

    public function __toString(): string
    {
        return $this->role ?? '';
    }

    /**
     * @return Collection<int, PagePerm>
     */
    public function getPagePerms(): Collection
    {
        return $this->pagePerms;
    }

    public function addPagePerm(PagePerm $pagePerm): static
    {
        if (!$this->pagePerms->contains($pagePerm)) {
            $this->pagePerms->add($pagePerm);
            $pagePerm->addIdRole($this);
        }

        return $this;
    }

    public function removePagePerm(PagePerm $pagePerm): static
    {
        if ($this->pagePerms->removeElement($pagePerm)) {
            $pagePerm->removeIdRole($this);
        }

        return $this;
    }

}