<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandesRepository")
 */
class Commandes
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Utilisateurs", mappedBy="cli_num")
     */
    private $cli_num;

    /**
     * @ORM\Column(type="datetime")
     */
    private $com_date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $com_obs;



    /**
     * @ORM\Column(type="boolean")
     */
    private $type_paiement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $com_adresse_livraison;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AccorderRemise", mappedBy="commandes", orphanRemoval=true)
     */
    private $accorderRemises;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateurs", inversedBy="commandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LigneCommandes", mappedBy="commandes", orphanRemoval=true)
     */
    private $ligneCommandes;

  

    public function __construct()
    {
        $this->cli_num = new ArrayCollection();
        $this->accorderRemises = new ArrayCollection();
        $this->ligneCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|utilisateurs[]
     */
    public function getCliNum(): Collection
    {
        return $this->cli_num;
    }

    public function addCliNum(utilisateurs $cliNum): self
    {
        if (!$this->cli_num->contains($cliNum)) {
            $this->cli_num[] = $cliNum;
            $cliNum->setCliNum($this);
        }

        return $this;
    }

    public function removeCliNum(utilisateurs $cliNum): self
    {
        if ($this->cli_num->contains($cliNum)) {
            $this->cli_num->removeElement($cliNum);
            // set the owning side to null (unless already changed)
            if ($cliNum->getCliNum() === $this) {
                $cliNum->setCliNum(null);
            }
        }

        return $this;
    }

    public function getComDate(): ?\DateTimeInterface
    {
        return $this->com_date;
    }

    public function setComDate(\DateTimeInterface $com_date): self
    {
        $this->com_date = $com_date;

        return $this;
    }

    public function getComObs(): ?string
    {
        return $this->com_obs;
    }

    public function setComObs(string $com_obs): self
    {
        $this->com_obs = $com_obs;

        return $this;
    }



    public function getTypePaiement(): ?bool
    {
        return $this->type_paiement;
    }

    public function setTypePaiement(bool $type_paiement): self
    {
        $this->type_paiement = $type_paiement;

        return $this;
    }

    public function getComAdresseLivraison(): ?string
    {
        return $this->com_adresse_livraison;
    }

    public function setComAdresseLivraison(string $com_adresse_livraison): self
    {
        $this->com_adresse_livraison = $com_adresse_livraison;

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
            $accorderRemise->setCommandes($this);
        }

        return $this;
    }

    public function removeAccorderRemise(AccorderRemise $accorderRemise): self
    {
        if ($this->accorderRemises->contains($accorderRemise)) {
            $this->accorderRemises->removeElement($accorderRemise);
            // set the owning side to null (unless already changed)
            if ($accorderRemise->getCommandes() === $this) {
                $accorderRemise->setCommandes(null);
            }
        }

        return $this;
    }

    public function getClient(): ?Utilisateurs
    {
        return $this->client;
    }

    public function setClient(?Utilisateurs $client): self
    {
        $this->client = $client;

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
            $ligneCommande->setCommandes($this);
        }

        return $this;
    }

    public function removeLigneCommande(LigneCommandes $ligneCommande): self
    {
        if ($this->ligneCommandes->contains($ligneCommande)) {
            $this->ligneCommandes->removeElement($ligneCommande);
            // set the owning side to null (unless already changed)
            if ($ligneCommande->getCommandes() === $this) {
                $ligneCommande->setCommandes(null);
            }
        }

        return $this;
    }
}
