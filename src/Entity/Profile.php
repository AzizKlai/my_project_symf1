<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use App\traits\TimeStampTrait;
use Doctrine\ORM\Mapping as ORM;
#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ProfileRepository::class)]
class Profile
{   use TimeStampTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $github;

    #[ORM\Column(type: 'string', length: 100)]
    private $facebook;

    #[ORM\Column(type: 'string', length: 100)]
    private $email;

    #[ORM\OneToOne(inversedBy: 'profile', targetEntity: Personne::class, cascade: ['persist', 'remove'])]
    private $personne;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGithub(): ?string
    {
        return $this->github;
    }

    public function setGithub(string $github): self
    {
        $this->github = $github;

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(string $facebook): self
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPersonne(): ?Personne
    {
        return $this->personne;
    }

    public function setPersonne(?Personne $personne): self
    {
        $this->personne = $personne;

        return $this;
    }
    public function __toString(): string
    {
        return $this->github." ".$this->facebook." ".$this->email;
    }
}
