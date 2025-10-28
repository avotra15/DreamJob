<?php

namespace App\Entity;

use App\Entity\Roles;
use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $nom = null;

    /**
     * @var Collection<int, Roles>
     */
    #[ORM\ManyToMany(targetEntity: Roles::class)]
    #[ORM\JoinTable(name: 'user_roles')]
    private Collection $roles;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $password = null;

    /**
     * @var Collection<int, JobDetails>
     */
    #[ORM\OneToMany(targetEntity: JobDetails::class, mappedBy: 'email')]
    private Collection $Titre;

    /**
     * @var Collection<int, CV>
     */
    #[ORM\OneToMany(targetEntity: CV::class, mappedBy: 'email_cand')]
    private Collection $cVs;


    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->Titre = new ArrayCollection();
        $this->cVs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return Collection<int, Roles>
     */
    public function getUserRoles(): Collection
    {
        return $this->roles;
    }

    public function addRole(Roles $role): static
    {
        if (!$this->roles->contains($role)) {
            $this->roles->add($role);
        }
        return $this;
    }

    public function removeRole(Roles $role): static
    {
        $this->roles->removeElement($role);
        return $this;
    }

    public function hasRole(string $rolenm): bool
    {
        foreach ($this->roles as $role) {
            if ($role->getRole() === $rolenm) {
                return true;
            }
        }
        return false;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function eraseCredentials(): void
    {
        // Effacer les données sensibles temporaires si nécessaire
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->getUserIdentifier();
    }

    /**
     * Méthode requise par UserInterface - retourne un tableau de chaînes
     */
    public function getRoles(): array
    {
        $roleNames = [];

        foreach ($this->roles as $role) {
            $rolenm = $role->getRole();   // ⚡ corrigé
            if ($rolenm) {
                $roleNames[] = $rolenm;
            }
        }

        if (empty($roleNames)) {
            $roleNames[] = 'ROLE_CANDIDAT';
        }

        return array_unique($roleNames);
    }

    /**
     * @return Collection<int, JobDetails>
     */
    public function getTitre(): Collection
    {
        return $this->Titre;
    }

    public function addTitre(JobDetails $titre): static
    {
        if (!$this->Titre->contains($titre)) {
            $this->Titre->add($titre);
            $titre->setEmail($this);
        }

        return $this;
    }

    public function removeTitre(JobDetails $titre): static
    {
        if ($this->Titre->removeElement($titre)) {
            // set the owning side to null (unless already changed)
            if ($titre->getEmail() === $this) {
                $titre->setEmail(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CV>
     */
    public function getCVs(): Collection
    {
        return $this->cVs;
    }

    public function addCV(CV $cV): static
    {
        if (!$this->cVs->contains($cV)) {
            $this->cVs->add($cV);
            $cV->setEmailCand($this);
        }

        return $this;
    }

    public function removeCV(CV $cV): static
    {
        if ($this->cVs->removeElement($cV)) {
            // set the owning side to null (unless already changed)
            if ($cV->getEmailCand() === $this) {
                $cV->setEmailCand(null);
            }
        }

        return $this;
    }
}