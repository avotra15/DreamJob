<?php

namespace App\Entity;

use App\Repository\PagePermRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PagePermRepository::class)]
class PagePerm
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Roles>
     */
    #[ORM\ManyToMany(targetEntity: Roles::class, inversedBy: 'pagePerms')]
    private Collection $id_role;

    /**
     * @var Collection<int, Pages>
     */
    #[ORM\ManyToMany(targetEntity: Pages::class, inversedBy: 'pagePerms')]
    private Collection $id_page;

    /**
     * @var Collection<int, Permissions>
     */
    #[ORM\ManyToMany(targetEntity: Permissions::class, inversedBy: 'pagePerms')]
    private Collection $id_perm;

    public function __construct()
    {
        $this->id_role = new ArrayCollection();
        $this->id_page = new ArrayCollection();
        $this->id_perm = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Roles>
     */
    public function getIdRole(): Collection
    {
        return $this->id_role;
    }

    public function addIdRole(Roles $idRole): static
    {
        if (!$this->id_role->contains($idRole)) {
            $this->id_role->add($idRole);
        }

        return $this;
    }

    public function removeIdRole(Roles $idRole): static
    {
        $this->id_role->removeElement($idRole);

        return $this;
    }

    /**
     * @return Collection<int, Pages>
     */
    public function getIdPage(): Collection
    {
        return $this->id_page;
    }

    public function addIdPage(Pages $idPage): static
    {
        if (!$this->id_page->contains($idPage)) {
            $this->id_page->add($idPage);
        }

        return $this;
    }

    public function removeIdPage(Pages $idPage): static
    {
        $this->id_page->removeElement($idPage);

        return $this;
    }

    /**
     * @return Collection<int, Permissions>
     */
    public function getIdPerm(): Collection
    {
        return $this->id_perm;
    }

    public function addIdPerm(Permissions $idPerm): static
    {
        if (!$this->id_perm->contains($idPerm)) {
            $this->id_perm->add($idPerm);
        }

        return $this;
    }

    public function removeIdPerm(Permissions $idPerm): static
    {
        $this->id_perm->removeElement($idPerm);

        return $this;
    }
}