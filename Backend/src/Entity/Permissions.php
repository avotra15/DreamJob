<?php

namespace App\Entity;

use App\Repository\PermissionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PermissionsRepository::class)]
class Permissions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomperm = null;

    /**
     * @var Collection<int, PagePerm>
     */
    #[ORM\ManyToMany(targetEntity: PagePerm::class, mappedBy: 'id_perm')]
    private Collection $pagePerms;

    public function __construct()
    {
        $this->pagePerms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomperm(): ?string
    {
        return $this->nomperm;
    }

    public function setNomperm(string $nomperm): static
    {
        $this->nomperm = $nomperm;

        return $this;
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
            $pagePerm->addIdPerm($this);
        }

        return $this;
    }

    public function removePagePerm(PagePerm $pagePerm): static
    {
        if ($this->pagePerms->removeElement($pagePerm)) {
            $pagePerm->removeIdPerm($this);
        }

        return $this;
    }
}
