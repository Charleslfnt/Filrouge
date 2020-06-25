<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GererProPerRepository")
 */
class GererProPer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Produits", inversedBy="personnels")
     */
    private $produits;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Personnel", inversedBy="gererProPers")
     */
    private $personnels;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPersonnels(): ?personnel
    {
        return $this->personnels;
    }

    public function setPersonnels(?personnel $personnels): self
    {
        $this->personnels = $personnels;

        return $this;
    }
}
