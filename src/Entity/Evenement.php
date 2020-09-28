<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EvenementRepository::class)
 * @ApiResource()
 */
class Evenement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le nom de l'evènement est obligatoire")
     * @Assert\Length(min=3,minMessage="Le nom de l'évenement doit être de 3 caractères au moins",max=255,
     *     maxMessage="Le nom de l'évenement ne doit pas depasser 255 caractères")
     */
    private $nom;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message=" l'evènement doit avoir obligatoirement une date de début")
     * @Assert\DateTime(message="La date doit être au format AAAA-MM-JJ")
     */
    private $datedebut;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message=" l'evènement doit avoir obligatoirement une date de fin")
     * @Assert\DateTime(message="La date doit être au format AAAA-MM-JJ")
     */
    private $datefin;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message=" l'evènement doit avoir obligatoirement une date de création")
     * @Assert\DateTime(message="La date doit être au format AAAA-MM-JJ")
     */
    private $datecreation;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message=" l'evènement doit avoir obligatoirement une capacité d'accueil")
     */
    private $capaciteaccueil;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message=" l'evènement doit avoir obligatoirement un statut soit 'en cours' ou 'terminée'")
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=Inscription::class, mappedBy="evenement")
     */
    private $inscriptions;

    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
    }

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

    public function getDatedebut(): ?\DateTimeInterface
    {
        return $this->datedebut;
    }

    public function setDatedebut(\DateTimeInterface $datedebut): self
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    public function getDatefin(): ?\DateTimeInterface
    {
        return $this->datefin;
    }

    public function setDatefin(\DateTimeInterface $datefin): self
    {
        $this->datefin = $datefin;

        return $this;
    }

    public function getDatecreation(): ?\DateTimeInterface
    {
        return $this->datecreation;
    }

    public function setDatecreation(\DateTimeInterface $datecreation): self
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    public function getCapaciteaccueil(): ?int
    {
        return $this->capaciteaccueil;
    }

    public function setCapaciteaccueil(int $capaciteaccueil): self
    {
        $this->capaciteaccueil = $capaciteaccueil;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|Inscription[]
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscription $inscription): self
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions[] = $inscription;
            $inscription->setEvenement($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): self
    {
        if ($this->inscriptions->contains($inscription)) {
            $this->inscriptions->removeElement($inscription);
            // set the owning side to null (unless already changed)
            if ($inscription->getEvenement() === $this) {
                $inscription->setEvenement(null);
            }
        }

        return $this;
    }
}
