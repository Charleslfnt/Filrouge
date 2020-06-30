<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateursRepository")
 * @UniqueEntity(
 * fields= {"user_email"},
 * message= "L'email que vous avez indiqué est déjà utilisé"
 * )
 */
class Utilisateurs implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=2)
     */
    private $user_name;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8", minMessage="votre mot de passe doit contenir minimum 8 caractères ^^")
     */
    private $user_password;

    /**
     * @Assert\EqualTo(propertyPath="user_password")
     * @Assert\EqualTo(propertyPath="user_passwordConfirm", message="Votre n'avez pas tapé le même mot de passe")
     */
    public $user_passwordConfirm;

    /**
     * @ORM\Column(type="integer")
     */
    private $user_role;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=2)
     */
    private $user_firstname;

   

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $user_phone;

    /**
     * @ORM\Column(type="string", length=255)
     * Assert\Email
     */
    private $user_email;





    /**
     * @ORM\Column(type="string", length=255)
     */
    private $user_adresse;

    /**
     * @ORM\Column(type="date")
     */
    private $user_date_inscription;

    /**
     * @ORM\Column(type="float")
     */
    private $user_coef;

   
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commandes", mappedBy="client", orphanRemoval=true)
     */
    private $commandes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Personnel", inversedBy="utilisateurs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $personnel;

    

    public function __construct()
    {
        $this->gerers = new ArrayCollection();
        $this->commandes = new ArrayCollection();
        $this->roles = ['ROLE_ADMIN'];
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserName(): ?string
    {
        return $this->user_name;
    }

    public function setUserName(string $user_name): self
    {
        $this->user_name = $user_name;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->user_password;
    }

    public function setPassword(string $user_password): self
    {
        $this->user_password = $user_password;

        return $this;
    }


    public function getUserPassword(): ?string
    {
        return $this->user_password;
    }

    public function setUserPassword(string $user_password): self
    {
        $this->user_password = $user_password;

        return $this;
    }

    public function getUserRole(): ?int
    {
        return $this->user_role;
    }

    public function setUserRole(int $user_role): self
    {
        $this->user_role = $user_role;

        return $this;
    }

    public function getUserFirstname(): ?string
    {
        return $this->user_firstname;
    }

    public function setUserFirstname(string $user_firstname): self
    {
        $this->user_firstname = $user_firstname;

        return $this;
    }

    
    public function getUserPhone(): ?int
    {
        return $this->user_phone;
    }

    public function setUserPhone(int $user_phone): self
    {
        $this->user_phone = $user_phone;

        return $this;
    }

    public function eraseCredentials(){}
    public function getSalt() {}
    public function getRoles() {
        return ['ROLE_ADMIN'];
    }

    public function getUserEmail(): ?string
    {
        return $this->user_email;
    }

    public function setUserEmail(string $user_email): self
    {
        $this->user_email = $user_email;

        return $this;
    }

    public function getCliNum(): ?Commandes
    {
        return $this->cli_num;
    }

    public function setCliNum(?Commandes $cli_num): self
    {
        $this->cli_num = $cli_num;

        return $this;
    }

    public function getCommandes(): ?Commandes
    {
        return $this->commandes;
    }

    public function setCommandes(Commandes $commandes): self
    {
        $this->commandes = $commandes;

        // set the owning side of the relation if necessary
        if ($commandes->getUserId() !== $this) {
            $commandes->setUserId($this);
        }

        return $this;
    }

   

    public function getUserAdresse(): ?string
    {
        return $this->user_adresse;
    }

    public function setUserAdresse(string $user_adresse): self
    {
        $this->user_adresse = $user_adresse;

        return $this;
    }

    public function getUserDateInscription(): ?\DateTimeInterface
    {
        return $this->user_date_inscription;
    }

    public function setUserDateInscription(\DateTimeInterface $user_date_inscription): self
    {
        $this->user_date_inscription = $user_date_inscription;

        return $this;
    }

    public function getUserCoef(): ?float
    {
        return $this->user_coef;
    }

    public function setUserCoef(float $user_coef): self
    {
        $this->user_coef = $user_coef;

        return $this;
    }

   

    public function addCommande(Commandes $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setClient($this);
        }

        return $this;
    }

    public function removeCommande(Commandes $commande): self
    {
        if ($this->commandes->contains($commande)) {
            $this->commandes->removeElement($commande);
            // set the owning side to null (unless already changed)
            if ($commande->getClient() === $this) {
                $commande->setClient(null);
            }
        }

        return $this;
    }

    public function getPersonnel(): ?Personnel
    {
        return $this->personnel;
    }

    public function setPersonnel(?Personnel $personnel): self
    {
        $this->personnel = $personnel;

        return $this;
    }



   
}

