<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LigneCommandesRepository")
 */
class LigneCommandes
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $lig_quantite;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Livraison", mappedBy="ligne_commandes", orphanRemoval=true)
     */
    private $livraisons;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Commandes", inversedBy="ligneCommandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commandes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Produits", inversedBy="ligneCommandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $produit;

    public function __construct()
    {
        $this->livraisons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLigQuantite(): ?int
    {
        return $this->lig_quantite;
    }

    public function setLigQuantite(int $lig_quantite): self
    {
        $this->lig_quantite = $lig_quantite;

        return $this;
    }

    /**
     * @return Collection|Livraison[]
     */
    public function getLivraisons(): Collection
    {
        return $this->livraisons;
    }

    public function addLivraison(Livraison $livraison): self
    {
        if (!$this->livraisons->contains($livraison)) {
            $this->livraisons[] = $livraison;
            $livraison->setLigneCommandes($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): self
    {
        if ($this->livraisons->contains($livraison)) {
            $this->livraisons->removeElement($livraison);
            // set the owning side to null (unless already changed)
            if ($livraison->getLigneCommandes() === $this) {
                $livraison->setLigneCommandes(null);
            }
        }

        return $this;
    }

    public function getCommandes(): ?commandes
    {
        return $this->commandes;
    }

    public function setCommandes(?commandes $commandes): self
    {
        $this->commandes = $commandes;

        return $this;
    }

    public function getProduit(): ?produits
    {
        return $this->produit;
    }

    public function setProduit(?produits $produit): self
    {
        $this->produit = $produit;

        return $this;
    }
}
