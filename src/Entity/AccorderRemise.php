<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AccorderRemiseRepository")
 */
class AccorderRemise
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $montant_remise;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\commandes", inversedBy="accorderRemises")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commandes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\personnel", inversedBy="accorderRemises")
     */
    private $personnels;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantRemise(): ?float
    {
        return $this->montant_remise;
    }

    public function setMontantRemise(float $montant_remise): self
    {
        $this->montant_remise = $montant_remise;

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
