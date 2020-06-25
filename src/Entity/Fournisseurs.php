<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FournisseursRepository")
 */
class Fournisseurs
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
    private $Four_name;

   
    /**
     * @ORM\Column(type="string", length=10)
     */
    private $four_phone;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $four_email;

   

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Fournir", mappedBy="fournisseurs", orphanRemoval=true)
     */
    private $fournirs;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $four_adresse;

    public function __construct()
    {
        $this->gererPfs = new ArrayCollection();
        $this->fournirs = new ArrayCollection();
    }

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFourName(): ?string
    {
        return $this->Four_name;
    }

    public function setFourName(string $Four_name): self
    {
        $this->Four_name = $Four_name;

        return $this;
    }

   
    public function getFourPhone(): ?string
    {
        return $this->four_phone;
    }

    public function setFourPhone(string $four_phone): self
    {
        $this->four_phone = $four_phone;

        return $this;
    }

    public function getFourEmail(): ?string
    {
        return $this->four_email;
    }

    public function setFourEmail(string $four_email): self
    {
        $this->four_email = $four_email;

        return $this;
    }

   

    /**
     * @return Collection|Fournir[]
     */
    public function getFournirs(): Collection
    {
        return $this->fournirs;
    }

    public function addFournir(Fournir $fournir): self
    {
        if (!$this->fournirs->contains($fournir)) {
            $this->fournirs[] = $fournir;
            $fournir->setFournisseurs($this);
        }

        return $this;
    }

    public function removeFournir(Fournir $fournir): self
    {
        if ($this->fournirs->contains($fournir)) {
            $this->fournirs->removeElement($fournir);
            // set the owning side to null (unless already changed)
            if ($fournir->getFournisseurs() === $this) {
                $fournir->setFournisseurs(null);
            }
        }

        return $this;
    }

    public function getFourAdresse(): ?string
    {
        return $this->four_adresse;
    }

    public function setFourAdresse(string $four_adresse): self
    {
        $this->four_adresse = $four_adresse;

        return $this;
    }

}
