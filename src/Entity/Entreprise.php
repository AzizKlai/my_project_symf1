<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntrepriseRepository::class)]
class Entreprise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $name;

    #[ORM\Column(type: 'string', length: 100)]
    private $domain;

    #[ORM\OneToMany(mappedBy: 'entreprise', targetEntity: Pfe::class)]
    private $Pfes;

    public function __construct()
    {
        $this->Pfes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDomain(): ?string
    {
        return $this->domain;
    }

    public function setDomain(string $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * @return Collection<int, Pfe>
     */
    public function getPfes(): Collection
    {
        return $this->Pfes;
    }

    public function addPfe(Pfe $pfe): self
    {
        if (!$this->Pfes->contains($pfe)) {
            $this->Pfes[] = $pfe;
            $pfe->setEntreprise($this);
        }

        return $this;
    }

    public function removePfe(Pfe $pfe): self
    {
        if ($this->Pfes->removeElement($pfe)) {
            // set the owning side to null (unless already changed)
            if ($pfe->getEntreprise() === $this) {
                $pfe->setEntreprise(null);
            }
        }

        return $this;
    }
}
