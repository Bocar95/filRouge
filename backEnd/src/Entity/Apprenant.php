<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ApprenantRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ApprenantRepository::class)
 * @ApiResource(
 *      normalizationContext={"groups"={"Apprenant:read_A","Apprenant:read_all","Stat_apprenant","Apprenant_stat","Brief:app_read"}},
 *       itemOperations={
 *                  "get"={"path"="/apprenants/{id}"}
 *      }
 * )
 */
class Apprenant extends User
{

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"Promo:read_P","GroupeApprenant:read_GA","Apprenant:read_A"})
     */
    private $genre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"Promo:read_P","GroupeApprenant:read_GA","Apprenant:read_A","Stat_apprenant","Apprenant_stat"})
     */
    private $statut;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"Apprenant:read_A","GroupeApprenant:read_GA","Promo:read_P"})
     */
    private $infoComplementaire;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeApprenant::class, mappedBy="apprenants")
     */
    private $groupeApprenants;

    /**
     * @ORM\OneToMany(targetEntity=LivrableRendu::class, mappedBy="apprenant")
     */
    private $livrableRendus;

    /**
     * @ORM\OneToMany(targetEntity=Livrables::class, mappedBy="apprenant")
     */
    private $livrables;

    /**
     * @ORM\OneToMany(targetEntity=StatistiquesCompetences::class, mappedBy="apprenant")
     */
    private $statistiquesCompetences;

    /**
     * @ORM\OneToMany(targetEntity=ApprenantLivrablePartiel::class, mappedBy="apprenant")
     */
    private $apprenantLivrablePartiels;

    /**
     * @ORM\OneToMany(targetEntity=PromoBriefApprenant::class, mappedBy="apprenant")
     */
    private $promoBriefApprenant;


    /**
     * @ORM\ManyToOne(targetEntity=ProfilSortie::class, inversedBy="apprenants")
     * @Groups({"Promo:read_P","GroupeApprenant:read_GA","Apprenant:read_A"})
     */
    private $profilSortie;


    public function __construct()
    {
        $this->groupeApprenants = new ArrayCollection();
        $this->livrableRendus = new ArrayCollection();
        $this->livrables = new ArrayCollection();
        $this->statistiquesCompetences = new ArrayCollection();
        $this->apprenantLivrablePartiels = new ArrayCollection();
        $this->promoBriefApprenant = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getInfoComplementaire(): ?string
    {
        return $this->infoComplementaire;
    }

    public function setInfoComplementaire(?string $infoComplementaire): self
    {
        $this->infoComplementaire = $infoComplementaire;

        return $this;
    }

    /**
     * @return Collection|GroupeApprenant[]
     */
    public function getGroupeApprenants(): Collection
    {
        return $this->groupeApprenants;
    }

    public function addGroupeApprenant(GroupeApprenant $groupeApprenant): self
    {
        if (!$this->groupeApprenants->contains($groupeApprenant)) {
            $this->groupeApprenants[] = $groupeApprenant;
            $groupeApprenant->addApprenant($this);
        }

        return $this;
    }

    public function removeGroupeApprenant(GroupeApprenant $groupeApprenant): self
    {
        if ($this->groupeApprenants->contains($groupeApprenant)) {
            $this->groupeApprenants->removeElement($groupeApprenant);
            $groupeApprenant->removeApprenant($this);
        }

        return $this;
    }

    /**
     * @return Collection|LivrableRendu[]
     */
    public function getLivrableRendus(): Collection
    {
        return $this->livrableRendus;
    }

    public function addLivrableRendu(LivrableRendu $livrableRendu): self
    {
        if (!$this->livrableRendus->contains($livrableRendu)) {
            $this->livrableRendus[] = $livrableRendu;
            $livrableRendu->setApprenant($this);
        }

        return $this;
    }

    public function removeLivrableRendu(LivrableRendu $livrableRendu): self
    {
        if ($this->livrableRendus->contains($livrableRendu)) {
            $this->livrableRendus->removeElement($livrableRendu);
            // set the owning side to null (unless already changed)
            if ($livrableRendu->getApprenant() === $this) {
                $livrableRendu->setApprenant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Livrables[]
     */
    public function getLivrables(): Collection
    {
        return $this->livrables;
    }

    public function addLivrable(Livrables $livrable): self
    {
        if (!$this->livrables->contains($livrable)) {
            $this->livrables[] = $livrable;
            $livrable->setApprenant($this);
        }

        return $this;
    }

    public function removeLivrable(Livrables $livrable): self
    {
        if ($this->livrables->contains($livrable)) {
            $this->livrables->removeElement($livrable);
            // set the owning side to null (unless already changed)
            if ($livrable->getApprenant() === $this) {
                $livrable->setApprenant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|StatistiquesCompetences[]
     */
    public function getStatistiquesCompetences(): Collection
    {
        return $this->statistiquesCompetences;
    }

    public function addStatistiquesCompetence(StatistiquesCompetences $statistiquesCompetence): self
    {
        if (!$this->statistiquesCompetences->contains($statistiquesCompetence)) {
            $this->statistiquesCompetences[] = $statistiquesCompetence;
            $statistiquesCompetence->setApprenant($this);
        }

        return $this;
    }

    public function removeStatistiquesCompetence(StatistiquesCompetences $statistiquesCompetence): self
    {
        if ($this->statistiquesCompetences->contains($statistiquesCompetence)) {
            $this->statistiquesCompetences->removeElement($statistiquesCompetence);
            // set the owning side to null (unless already changed)
            if ($statistiquesCompetence->getApprenant() === $this) {
                $statistiquesCompetence->setApprenant(null);
            }
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
            $apprenantLivrablePartiel->setApprenant($this);
        }

        return $this;
    }

    public function removeApprenantLivrablePartiel(ApprenantLivrablePartiel $apprenantLivrablePartiel): self
    {
        if ($this->apprenantLivrablePartiels->contains($apprenantLivrablePartiel)) {
            $this->apprenantLivrablePartiels->removeElement($apprenantLivrablePartiel);
            // set the owning side to null (unless already changed)
            if ($apprenantLivrablePartiel->getApprenant() === $this) {
                $apprenantLivrablePartiel->setApprenant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PromoBriefApprenant[]
     */
    public function getPromoBriefApprenant(): Collection
    {
        return $this->promoBriefApprenant;
    }

    public function addPromoBriefApprenant(PromoBriefApprenant $promoBriefApprenant): self
    {
        if (!$this->promoBriefApprenant->contains($promoBriefApprenant)) {
            $this->promoBriefApprenant[] = $promoBriefApprenant;
            $promoBriefApprenant->setApprenant($this);
        }

        return $this;
    }

    public function removePromoBriefApprenant(PromoBriefApprenant $promoBriefApprenant): self
    {
        if ($this->promoBriefApprenant->contains($promoBriefApprenant)) {
            $this->promoBriefApprenant->removeElement($promoBriefApprenant);
            // set the owning side to null (unless already changed)
            if ($promoBriefApprenant->getApprenant() === $this) {
                $promoBriefApprenant->setApprenant(null);
            }
        }

        return $this;
    }

    public function getProfilSortie(): ?ProfilSortie
    {
        return $this->profilSortie;
    }

    public function setProfilSortie(?ProfilSortie $profilSortie): self
    {
        $this->profilSortie = $profilSortie;

        return $this;
    }

}
