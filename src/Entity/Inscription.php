<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\InscriptionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=InscriptionRepository::class)
 * @ApiResource(
 *     attributes={
 *               "order":{"createdAt":"Asc"}
 *     }
 * )
 *
 *
 *
 */
class Inscription
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message=" l'Inscription doit avoir obligatoirement un nom")
     * @Assert\Length(min=3,minMessage="Le nom doit être de 3 caractères au moins",max=255,
     *     maxMessage="Le nom ne doit pas depasser 50 caractères")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message=" l'Inscription doit avoir obligatoirement un prenom")
     * @Assert\Length(min=3,minMessage="Le prenom doit être de 3 caractères au moins",max=255,
     *     maxMessage="Le prenom ne doit pas depasser 50 caractères")
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message=" l'email est obligatoire")
     * @Assert\Email(message=" le format de l'adresse email doit etre valide")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message=" le numéro de téléphone est obligatoire")
     * @Assert\Length(min=10,minMessage="Le prenom doit être de 10 caractères au moins",max=14,
     *     maxMessage="Le prenom ne doit pas depasser 14 caractères")
     */
    private $telephone;

    /**
     * @ORM\ManyToOne(targetEntity=Evenement::class, inversedBy="inscriptions")
     * @Assert\NotBlank(message=" l'évènement lié est obligatoire")
     */
    private $evenement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEvenement(): ?Evenement
    {
        return $this->evenement;
    }

    public function setEvenement(?Evenement $evenement): self
    {
        $this->evenement = $evenement;

        return $this;
    }
}
