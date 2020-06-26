<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProduitsRepository")
 */
class Produits
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
    private $pro_libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/^\w+/")
     */
    private $pro_description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pro_ref;

    /**
     * @ORM\Column(type="float")
     */
    private $pro_prix;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pro_photo;

    /**
     * @ORM\Column(type="date")
     */
    private $pro_ajout;

    /**
     * @ORM\Column(type="integer")
     */
    private $pro_stock;

 

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Fournisseurs", mappedBy="produits")
     */
    private $pro_four;

    /**
     * @ORM\Column(type="integer")
     */
    private $pro_stock_alert;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Fournir", mappedBy="produits", orphanRemoval=true)
     */
    private $fournirs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\GererProPer", mappedBy="produits")
     */
    private $gererproper;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Rubrique", inversedBy="produits")
     */
    private $rubriques;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LigneCommandes", mappedBy="produit", orphanRemoval=true)
     */
    private $ligneCommandes;

    public function __construct()
    {
        $this->pro_four = new ArrayCollection();
        $this->fournirs = new ArrayCollection();
        $this->gererproper = new ArrayCollection();
        $this->ligneCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProLibelle(): ?string
    {
        return $this->pro_libelle;
    }

    public function setProLibelle(string $pro_libelle): self
    {
        $this->pro_libelle = $pro_libelle;

        return $this;
    }

    public function getProDescription(): ?string
    {
        return $this->pro_description;
    }

    public function setProDescription(string $pro_description): self
    {
        $this->pro_description = $pro_description;

        return $this;
    }

    public function getProRef(): ?string
    {
        return $this->pro_ref;
    }

    public function setProRef(string $pro_ref): self
    {
        $this->pro_ref = $pro_ref;

        return $this;
    }

    public function getProPrix(): ?int
    {
        return $this->pro_prix;
    }

    public function setProPrix(int $pro_prix): self
    {
        $this->pro_prix = $pro_prix;

        return $this;
    }

    public function getProPhoto()
    {
        return $this->pro_photo;
    }

    public function setProPhoto($pro_photo): self
    {
        $this->pro_photo = $pro_photo;

        return $this;
    }

    public function getProAjout(): ?\DateTimeInterface
    {
        return $this->pro_ajout;
    }

    public function setProAjout(\DateTimeInterface $pro_ajout): self
    {
        $this->pro_ajout = $pro_ajout;

        return $this;
    }

    public function getProStock(): ?int
    {
        return $this->pro_stock;
    }

    public function setProStock(int $pro_stock): self
    {
        $this->pro_stock = $pro_stock;

        return $this;
    }



    /**
     * @return Collection|Fournisseurs[]
     */
    public function getProFour(): Collection
    {
        return $this->pro_four;
    }

    public function addProFour(Fournisseurs $proFour): self
    {
        if (!$this->pro_four->contains($proFour)) {
            $this->pro_four[] = $proFour;
            $proFour->setProduits($this);
        }

        return $this;
    }

    public function removeProFour(Fournisseurs $proFour): self
    {
        if ($this->pro_four->contains($proFour)) {
            $this->pro_four->removeElement($proFour);
            // set the owning side to null (unless already changed)
            if ($proFour->getProduits() === $this) {
                $proFour->setProduits(null);
            }
        }

        return $this;
    }

    public function getProStockAlert(): ?int
    {
        return $this->pro_stock_alert;
    }

    public function setProStockAlert(int $pro_stock_alert): self
    {
        $this->pro_stock_alert = $pro_stock_alert;

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
            $fournir->setProduits($this);
        }

        return $this;
    }

    public function removeFournir(Fournir $fournir): self
    {
        if ($this->fournirs->contains($fournir)) {
            $this->fournirs->removeElement($fournir);
            // set the owning side to null (unless already changed)
            if ($fournir->getProduits() === $this) {
                $fournir->setProduits(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|GererProPer[]
     */
    public function getgererproper(): Collection
    {
        return $this->gererproper;
    }

    public function addPersonnel(GererProPer $personnel): self
    {
        if (!$this->gererproper->contains($personnel)) {
            $this->gererproper[] = $personnel;
            $personnel->setProduits($this);
        }

        return $this;
    }

    public function removePersonnel(GererProPer $personnel): self
    {
        if ($this->gererproper->contains($personnel)) {
            $this->gererproper->removeElement($personnel);
            // set the owning side to null (unless already changed)
            if ($personnel->getProduits() === $this) {
                $personnel->setProduits(null);
            }
        }

        return $this;
    }

    public function getRubriques(): ?Rubrique
    {
        return $this->rubriques;
    }

    public function setRubriques(?Rubrique $rubriques): self
    {
        $this->rubriques = $rubriques;

        return $this;
    }

    /**
     * @return Collection|LigneCommandes[]
     */
    public function getLigneCommandes(): Collection
    {
        return $this->ligneCommandes;
    }

    public function addLigneCommande(LigneCommandes $ligneCommande): self
    {
        if (!$this->ligneCommandes->contains($ligneCommande)) {
            $this->ligneCommandes[] = $ligneCommande;
            $ligneCommande->setProduit($this);
        }

        return $this;
    }

    public function removeLigneCommande(LigneCommandes $ligneCommande): self
    {
        if ($this->ligneCommandes->contains($ligneCommande)) {
            $this->ligneCommandes->removeElement($ligneCommande);
            // set the owning side to null (unless already changed)
            if ($ligneCommande->getProduit() === $this) {
                $ligneCommande->setProduit(null);
            }
        }

        return $this;
    }
}
