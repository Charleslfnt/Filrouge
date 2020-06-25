<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonnelRepository")
 */
class Personnel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $per_matricule;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $per_service;

 
  

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\GererProPer", mappedBy="personnels")
     */
    private $gererProPers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AccorderRemise", mappedBy="personnels")
     */
    private $accorderRemises;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Utilisateurs", mappedBy="personnel")
     */
    private $utilisateurs;

    public function __construct()
    {
        $this->gerers = new ArrayCollection();
        $this->gererPfs = new ArrayCollection();
        $this->gererProPers = new ArrayCollection();
        $this->accorderRemises = new ArrayCollection();
        $this->utilisateurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPerMatricule(): ?string
    {
        return $this->per_matricule;
    }

    public function setPerMatricule(string $per_matricule): self
    {
        $this->per_matricule = $per_matricule;

        return $this;
    }

    public function getPerService(): ?string
    {
        return $this->per_service;
    }

    public function setPerService(string $per_service): self
    {
        $this->per_service = $per_service;

        return $this;
    }

    

    

    /**
     * @return Collection|GererProPer[]
     */
    public function getGererProPers(): Collection
    {
        return $this->gererProPers;
    }

    public function addGererProPer(GererProPer $gererProPer): self
    {
        if (!$this->gererProPers->contains($gererProPer)) {
            $this->gererProPers[] = $gererProPer;
            $gererProPer->setPersonnels($this);
        }

        return $this;
    }

    public function removeGererProPer(GererProPer $gererProPer): self
    {
        if ($this->gererProPers->contains($gererProPer)) {
            $this->gererProPers->removeElement($gererProPer);
            // set the owning side to null (unless already changed)
            if ($gererProPer->getPersonnels() === $this) {
                $gererProPer->setPersonnels(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AccorderRemise[]
     */
    public function getAccorderRemises(): Collection
    {
        return $this->accorderRemises;
    }

    public function addAccorderRemise(AccorderRemise $accorderRemise): self
    {
        if (!$this->accorderRemises->contains($accorderRemise)) {
            $this->accorderRemises[] = $accorderRemise;
            $accorderRemise->setPersonnels($this);
        }

        return $this;
    }

    public function removeAccorderRemise(AccorderRemise $accorderRemise): self
    {
        if ($this->accorderRemises->contains($accorderRemise)) {
            $this->accorderRemises->removeElement($accorderRemise);
            // set the owning side to null (unless already changed)
            if ($accorderRemise->getPersonnels() === $this) {
                $accorderRemise->setPersonnels(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Utilisateurs[]
     */
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(Utilisateurs $utilisateur): self
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs[] = $utilisateur;
            $utilisateur->setPersonnel($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateurs $utilisateur): self
    {
        if ($this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs->removeElement($utilisateur);
            // set the owning side to null (unless already changed)
            if ($utilisateur->getPersonnel() === $this) {
                $utilisateur->setPersonnel(null);
            }
        }

        return $this;
    }
}
