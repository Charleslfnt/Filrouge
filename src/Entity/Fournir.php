<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FournirRepository")
 */
class Fournir
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Fournisseurs", inversedBy="fournirs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fournisseurs;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Produits", inversedBy="fournirs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $produits;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFournisseurs(): ?fournisseurs
    {
        return $this->fournisseurs;
    }

    public function setFournisseurs(?fournisseurs $fournisseurs): self
    {
        $this->fournisseurs = $fournisseurs;

        return $this;
    }

    public function getProduits(): ?produits
    {
        return $this->produits;
    }

    public function setProduits(?produits $produits): self
    {
        $this->produits = $produits;

        return $this;
    }
}
