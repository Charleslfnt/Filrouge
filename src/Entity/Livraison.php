<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LivraisonRepository")
 */
class Livraison
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $liv_date;

    /**
     * @ORM\Column(type="integer")
     */
    private $liv_quantite;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\LigneCommandes", inversedBy="livraisons")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ligne_commandes;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLivDate(): ?\DateTimeInterface
    {
        return $this->liv_date;
    }

    public function setLivDate(\DateTimeInterface $liv_date): self
    {
        $this->liv_date = $liv_date;

        return $this;
    }

    public function getLivQuantite(): ?int
    {
        return $this->liv_quantite;
    }

    public function setLivQuantite(int $liv_quantite): self
    {
        $this->liv_quantite = $liv_quantite;

        return $this;
    }

    public function getLigneCommandes(): ?LigneCommandes
    {
        return $this->ligne_commandes;
    }

    public function setLigneCommandes(?LigneCommandes $ligne_commandes): self
    {
        $this->ligne_commandes = $ligne_commandes;

        return $this;
    }
}
