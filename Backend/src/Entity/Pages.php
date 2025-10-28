<?php

namespace App\Entity;

use App\Repository\PagesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PagesRepository::class)]
class Pages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $page = null;

    #[ORM\Column(length: 255)]
    private ?string $path = null;

    /**
     * @var Collection<int, PagePerm>
     */
    #[ORM\ManyToMany(targetEntity: PagePerm::class, mappedBy: 'id_page')]
    private Collection $pagePerms;

    public function __construct()
    {
        $this->pagePerms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPage(): ?string
    {
        return $this->page;
    }

    public function setPage(string $page): static
    {
        $this->page = $page;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): static
    {
        $this->path = $path;

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
            $pagePerm->addIdPage($this);
        }

        return $this;
    }

    public function removePagePerm(PagePerm $pagePerm): static
    {
        if ($this->pagePerms->removeElement($pagePerm)) {
            $pagePerm->removeIdPage($this);
        }

        return $this;
    }
}
