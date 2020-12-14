<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LivrablesPartielsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=LivrablesPartielsRepository::class)
 */
class LivrablesPartiels
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"PromoBrief:read_PB"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"PromoBrief:read_PB"})
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     * @Groups({"PromoBrief:read_PB"})
     */
    private $delai;

    /**
     * @ORM\Column(type="date")
     * @Groups({"PromoBrief:read_PB"})
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"PromoBrief:read_PB"})
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=PromoBrief::class, inversedBy="livrablesPartiels")
     */
    private $promoBrief;

    /**
     * @ORM\OneToMany(targetEntity=LivrableRendu::class, mappedBy="livrablesPartiels")
     * @Groups({"PromoBrief:read_PB"})
     */
    private $livrableRendu;

    /**
     * @ORM\ManyToMany(targetEntity=Niveau::class, mappedBy="livrablesPartiels")
     * @Groups({"PromoBrief:read_PB"})
     */
    private $niveaux;

    /**
     * @ORM\OneToMany(targetEntity=ApprenantLivrablePartiel::class, mappedBy="livrablePartiel")
     */
    private $apprenantLivrablePartiels;


    public function __construct()
    {
        $this->livrableRendu = new ArrayCollection();
        $this->niveaux = new ArrayCollection();
        $this->apprenantLivrablePartiels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDelai(): ?\DateTimeInterface
    {
        return $this->delai;
    }

    public function setDelai(\DateTimeInterface $delai): self
    {
        $this->delai = $delai;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPromoBrief(): ?PromoBrief
    {
        return $this->promoBrief;
    }

    public function setPromoBrief(?PromoBrief $promoBrief): self
    {
        $this->promoBrief = $promoBrief;

        return $this;
    }

    /**
     * @return Collection|LivrableRendu[]
     */
    public function getLivrableRendu(): Collection
    {
        return $this->livrableRendu;
    }

    public function addLivrableRendu(LivrableRendu $livrableRendu): self
    {
        if (!$this->livrableRendu->contains($livrableRendu)) {
            $this->livrableRendu[] = $livrableRendu;
            $livrableRendu->setLivrablesPartiels($this);
        }

        return $this;
    }

    public function removeLivrableRendu(LivrableRendu $livrableRendu): self
    {
        if ($this->livrableRendu->contains($livrableRendu)) {
            $this->livrableRendu->removeElement($livrableRendu);
            // set the owning side to null (unless already changed)
            if ($livrableRendu->getLivrablesPartiels() === $this) {
                $livrableRendu->setLivrablesPartiels(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Niveau[]
     */
    public function getNiveaux(): Collection
    {
        return $this->niveaux;
    }

    public function addNiveau(Niveau $niveau): self
    {
        if (!$this->niveaux->contains($niveau)) {
            $this->niveaux[] = $niveau;
            $niveau->addLivrablesPartiel($this);
        }

        return $this;
    }

    public function removeNiveau(Niveau $niveau): self
    {
        if ($this->niveaux->contains($niveau)) {
            $this->niveaux->removeElement($niveau);
            $niveau->removeLivrablesPartiel($this);
        }

        return $this;
    }

    /**
     * @return Collection|ApprenantLivrablePartiel[]
     */
    public function getApprenantLivrablePartiels(): Collection
    {
        return $this->apprenantLivrablePartiels;
    }

    public function addApprenantLivrablePartiel(ApprenantLivrablePartiel $apprenantLivrablePartiel): self
    {
        if (!$this->apprenantLivrablePartiels->contains($apprenantLivrablePartiel)) {
            $this->apprenantLivrablePartiels[] = $apprenantLivrablePartiel;
            $apprenantLivrablePartiel->setLivrablePartiel($this);
        }

        return $this;
    }

    public function removeApprenantLivrablePartiel(ApprenantLivrablePartiel $apprenantLivrablePartiel): self
    {
        if ($this->apprenantLivrablePartiels->contains($apprenantLivrablePartiel)) {
            $this->apprenantLivrablePartiels->removeElement($apprenantLivrablePartiel);
            // set the owning side to null (unless already changed)
            if ($apprenantLivrablePartiel->getLivrablePartiel() === $this) {
                $apprenantLivrablePartiel->setLivrablePartiel(null);
            }
        }

        return $this;
    }

}
