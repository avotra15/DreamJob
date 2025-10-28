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
     * @var Collection<int, roles>
     */
    #[ORM\ManyToMany(targetEntity: roles::class, inversedBy: 'pagePerms')]
    private Collection $id_role;

    /**
     * @var Collection<int, pages>
     */
    #[ORM\ManyToMany(targetEntity: pages::class, inversedBy: 'pagePerms')]
    private Collection $id_page;

    /**
     * @var Collection<int, permissions>
     */
    #[ORM\ManyToMany(targetEntity: permissions::class, inversedBy: 'pagePerms')]
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
     * @return Collection<int, roles>
     */
    public function getIdRole(): Collection
    {
        return $this->id_role;
    }

    public function addIdRole(roles $idRole): static
    {
        if (!$this->id_role->contains($idRole)) {
            $this->id_role->add($idRole);
        }

        return $this;
    }

    public function removeIdRole(roles $idRole): static
    {
        $this->id_role->removeElement($idRole);

        return $this;
    }

    /**
     * @return Collection<int, pages>
     */
    public function getIdPage(): Collection
    {
        return $this->id_page;
    }

    public function addIdPage(pages $idPage): static
    {
        if (!$this->id_page->contains($idPage)) {
            $this->id_page->add($idPage);
        }

        return $this;
    }

    public function removeIdPage(pages $idPage): static
    {
        $this->id_page->removeElement($idPage);

        return $this;
    }

    /**
     * @return Collection<int, permissions>
     */
    public function getIdPerm(): Collection
    {
        return $this->id_perm;
    }

    public function addIdPerm(permissions $idPerm): static
    {
        if (!$this->id_perm->contains($idPerm)) {
            $this->id_perm->add($idPerm);
        }

        return $this;
    }

    public function removeIdPerm(permissions $idPerm): static
    {
        $this->id_perm->removeElement($idPerm);

        return $this;
    }
}
