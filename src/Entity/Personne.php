<?php

namespace App\Entity;

use App\Repository\PersonneRepository;
use App\traits\TimeStampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: PersonneRepository::class)]
class Personne
{
    use TimeStampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $firstname;

    #[ORM\Column(type: 'string', length: 70)]
    private $name;

    #[ORM\Column(type: 'smallint')]
    private $age;

    #[ORM\ManyToOne(targetEntity: Job::class, inversedBy: 'personnes')]
    private $job;

    #[ORM\ManyToMany(targetEntity: Hobby::class, mappedBy: 'personnes')]
    private $hobbies;

    #[ORM\OneToOne(mappedBy: 'personne', targetEntity: Profile::class, cascade: ['persist', 'remove'])]
    private $profile;

    public function __construct()
    {
        $this->hobbies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
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

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getJob(): ?Job
    {
        return $this->job;
    }

    public function setJob(?Job $job): self
    {
        $this->job = $job;

        return $this;
    }

    /**
     * @return Collection<int, Hobby>
     */
    public function getHobbies(): Collection
    {
        return $this->hobbies;
    }

    public function addHobby(Hobby $hobby): self
    {
        if (!$this->hobbies->contains($hobby)) {
            $this->hobbies[] = $hobby;
            $hobby->addPersonne($this);
        }

        return $this;
    }

    public function removeHobby(Hobby $hobby): self
    {
        if ($this->hobbies->removeElement($hobby)) {
            $hobby->removePersonne($this);
        }

        return $this;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): self
    {
        // unset the owning side of the relation if necessary
        if ($profile === null && $this->profile !== null) {
            $this->profile->setPersonne(null);
        }

        // set the owning side of the relation if necessary
        if ($profile !== null && $profile->getPersonne() !== $this) {
            $profile->setPersonne($this);
        }

        $this->profile = $profile;

        return $this;
    }


}
