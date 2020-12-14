<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LivrableRenduRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=LivrableRenduRepository::class)
 */
class LivrableRendu
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
    private $statut;

    /**
     * @ORM\Column(type="date")
     */
    private $delai;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateDeRendu;

    /**
     * @ORM\ManyToOne(targetEntity=LivrablesPartiels::class, inversedBy="livrableRendu")
     */
    private $livrablesPartiels;

    /**
     * @ORM\OneToMany(targetEntity=Commentaires::class, mappedBy="livrableRendu")
     */
    private $commentaires;

    /**
     * @ORM\ManyToOne(targetEntity=Apprenant::class, inversedBy="livrableRendus")
     */
    private $apprenant;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

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

    public function getDateDeRendu(): ?\DateTimeInterface
    {
        return $this->dateDeRendu;
    }

    public function setDateDeRendu(\DateTimeInterface $dateDeRendu): self
    {
        $this->dateDeRendu = $dateDeRendu;

        return $this;
    }

    public function getLivrablesPartiels(): ?LivrablesPartiels
    {
        return $this->livrablesPartiels;
    }

    public function setLivrablesPartiels(?LivrablesPartiels $livrablesPartiels): self
    {
        $this->livrablesPartiels = $livrablesPartiels;

        return $this;
    }

    /**
     * @return Collection|Commentaires[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaires $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setLivrableRendu($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaires $commentaire): self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getLivrableRendu() === $this) {
                $commentaire->setLivrableRendu(null);
            }
        }

        return $this;
    }

    public function getApprenant(): ?Apprenant
    {
        return $this->apprenant;
    }

    public function setApprenant(?Apprenant $apprenant): self
    {
        $this->apprenant = $apprenant;

        return $this;
    }
}
