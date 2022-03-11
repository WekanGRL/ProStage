<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=EntrepriseRepository::class)
 */
class Entreprise
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(
     *  message = "L'activité de l'entreprise doit être renseignée"
     * )
     */
    private $activite;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     *
     * @Assert\NotBlank(
     *  message = "L'adresse de l'entreprise doit être renseignée"
     * ) 
     *   
     * @Assert\Regex(
     *  pattern = "#^[1-999]( ?bis)?#",
     *  message =  "Le numéro de route/voie semble incorrect"
     * )
     * 
     * @Assert\Regex(
     *  pattern = "#route|rue|boulevard|avenue|impasse|voie|allée|place#i",
     *  message = "le type de route/voie semble incorrect"
     * )
     * 
     * @Assert\Regex(
     *  pattern = "# [0-9]{5} #",
     *  message = "Le code postal semble erroné"
     * )
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(
     *  message = "Le nom de l'entreprise doit être renseigné"
     * )
     * @Assert\Length (
     *  min = 4,
     *  max = 50,
     *  minMessage = "Le titre doit faire au minimum {{ limit }} caractères " ,
     *  maxMessage = "Le titre doit faire au maximum {{ limit }} caractères "
     * )
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     * @Assert\NotBlank(
     *  message = "L'URL de l'entreprise doit être renseignée"
     * )
     * @Assert\Url (
     * message = "Forme d'une URL requise"
     * )
     */
    private $urlsite;

    /**
     * @ORM\OneToMany(targetEntity=Stage::class, mappedBy="entreprises")
     */
    private $stages;

    public function __construct()
    {
        $this->stages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActivite(): ?string
    {
        return $this->activite;
    }

    public function setActivite(string $activite): self
    {
        $this->activite = $activite;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
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

    public function getUrlsite(): ?string
    {
        return $this->urlsite;
    }

    public function setUrlsite(?string $urlsite): self
    {
        $this->urlsite = $urlsite;

        return $this;
    }

    /**
     * @return Collection|Stage[]
     */
    public function getStages(): Collection
    {
        return $this->stages;
    }

    public function addStage(Stage $stage): self
    {
        if (!$this->stages->contains($stage)) {
            $this->stages[] = $stage;
            $stage->setEntreprises($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): self
    {
        if ($this->stages->removeElement($stage)) {
            // set the owning side to null (unless already changed)
            if ($stage->getEntreprises() === $this) {
                $stage->setEntreprises(null);
            }
        }

        return $this;
    }
}
