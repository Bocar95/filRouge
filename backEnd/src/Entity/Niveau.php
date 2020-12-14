<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\NiveauRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=NiveauRepository::class)
 * @ApiResource(
 *      normalizationContext={"groups"={"Niveau:read_NV","Niveau:read_all"}},
 * )
 */
class Niveau
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"Competences:read_N","Stat_apprenant","brief_of_promo","brief_of_groupe_of_promo","brief_broullon_of_formateur","brief_valide_of_formateur","one_brief_of_promo","brief_assigned","Stat_apprenant","Stat_competences","all_briefs"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Competences:read_N","GroupeApprenant:read_GA","brief_of_promo","brief_of_groupe_of_promo","brief_broullon_of_formateur","brief_valide_of_formateur","one_brief_of_promo","brief_assigned","Stat_apprenant","Stat_competences","all_briefs","Apprenant_stat"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Competences:read_N","GroupeApprenant:read_GA","brief_of_promo","brief_of_groupe_of_promo","brief_broullon_of_formateur","brief_valide_of_formateur","one_brief_of_promo","brief_assigned","Stat_apprenant","Stat_competences","all_briefs","Apprenant_stat"})
     */
    private $critereEvaluation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Competences:read_N","GroupeApprenant:read_GA","brief_of_promo","brief_of_groupe_of_promo","brief_broullon_of_formateur","brief_valide_of_formateur","one_brief_of_promo","brief_assigned","Stat_apprenant","Stat_competences","all_briefs","Apprenant_stat"})
     */
    private $groupeAction;

    /**
     * @ORM\ManyToOne(targetEntity=Competences::class, inversedBy="niveau")
     * @Groups({"Niveau:read_NV","brief_of_promo","brief_of_groupe_of_promo","brief_broullon_of_formateur","brief_valide_of_formateur","one_brief_of_promo","brief_assigned"})
     */
    private $competences;

    /**
     * @ORM\ManyToOne(targetEntity=Brief::class, inversedBy="niveaux")
     * @Groups({"Competences:read_N"})
     */
    private $brief;

    /**
     * @ORM\ManyToMany(targetEntity=LivrablesPartiels::class, inversedBy="niveaux")
     * @Groups({"Competences:read_N"})
     * @Groups({"Niveau:read_NV"})
     */
    private $livrablesPartiels;

    public function __construct()
    {
        $this->livrablesPartiels = new ArrayCollection();
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

    public function getCritereEvaluation(): ?string
    {
        return $this->critereEvaluation;
    }

    public function setCritereEvaluation(string $critereEvaluation): self
    {
        $this->critereEvaluation = $critereEvaluation;

        return $this;
    }

    public function getGroupeAction(): ?string
    {
        return $this->groupeAction;
    }

    public function setGroupeAction(string $groupeAction): self
    {
        $this->groupeAction = $groupeAction;

        return $this;
    }

    public function getCompetences(): ?Competences
    {
        return $this->competences;
    }

    public function setCompetences(?Competences $competences): self
    {
        $this->competences = $competences;

        return $this;
    }

    public function getBrief(): ?Brief
    {
        return $this->brief;
    }

    public function setBrief(?Brief $brief): self
    {
        $this->brief = $brief;

        return $this;
    }

    /**
     * @return Collection|LivrablesPartiels[]
     */
    public function getLivrablesPartiels(): Collection
    {
        return $this->livrablesPartiels;
    }

    public function addLivrablesPartiel(LivrablesPartiels $livrablesPartiel): self
    {
        if (!$this->livrablesPartiels->contains($livrablesPartiel)) {
            $this->livrablesPartiels[] = $livrablesPartiel;
        }

        return $this;
    }

    public function removeLivrablesPartiel(LivrablesPartiels $livrablesPartiel): self
    {
        if ($this->livrablesPartiels->contains($livrablesPartiel)) {
            $this->livrablesPartiels->removeElement($livrablesPartiel);
        }

        return $this;
    }
}
