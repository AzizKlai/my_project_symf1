<?php

namespace App\traits;
use Doctrine\ORM\Mapping as ORM;
trait TimeStampTrait
{
    #[ORM\Column(type: 'datetime', nullable: true)]
    private $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $updatedAt;
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
    /**
     * @ORM\PrePersist()
     */
    #[ORM\PrePersist]
    public function onPrePersist(){
        $this->createdAt=new \DateTime('now');
        $this->updatedAt=new \DateTime('now');
    }
    /**
     * @ORM\PreUpdate()
     */
    #[ORM\PreUpdate]
    public function onPreUpdate(){
        $this->updatedAt=new \DateTime('now');
    }


}