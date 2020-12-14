<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReferentielRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ReferentielRepository::class)
 * @ApiResource(
 *      normalizationContext={"groups"={"Referentiel:read_R","Referentiel:read_all","Ref:comp"}},
 *      collectionOperations={
 *          "get"={"path"="/admin/referentiels"},
 *          "getRefGrpCompetences"={
 *                            "methods"="get",
 *                            "path"="/api/admin/referentiels/grpecompetences",
 *                            "route_name"="apiGetRefGrpComp"
 *          },
 *          "post"={
 *                  "security_post_denormalize"="is_granted('EDIT', object)",
 *                  "security_post_denormalize_message"="Vous n'avez pas ce privilége.",
 *                  "path"="/admin/referentiels"
 *          }
 *      },
 *      itemOperations={
 *          "get"={
 *                  "security_post_denormalize"="is_granted('VIEW', object)",
 *                  "security_post_denormalize_message"="Vous n'avez pas ce privilége.",
 *                  "path"="/admin/referentiels/{id}",
 *                  "defaults"={"id"=null}
 *          },
 *          "getRefIdGrpCompetences"={
 *                              "methods"="get",
 *                              "path"="/api/admin/referentiels/{id}/grpecompetences",
 *                              "defaults"={"id"=null},
 *                              "route_name"="apiGetRefIdgrpComp"
 *           },
 *           "put"={
 *                  "security_post_denormalize"="is_granted('EDIT', object)",
 *                  "security_post_denormalize_message"="Vous n'avez pas ce privilége.",
 *                  "path"="/admin/referentiels/{id}",
 *                  "defaults"={"id"=null}
 *                 }
 *      }
 * )
 */
class Referentiel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"Referentiel:read_R","Promo:read_P","brief_of_promo","brief_of_groupe_of_promo","brief_broullon_of_formateur","brief_valide_of_formateur","one_brief_of_promo","brief_assigned","all_briefs"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"GroupeApprenant:read_GA","Referentiel:read_R","Promo:read_P","brief_of_promo","brief_of_groupe_of_promo","brief_broullon_of_formateur","brief_valide_of_formateur","one_brief_of_promo","brief_assigned","all_briefs"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"GroupeApprenant:read_GA","Promo:read_P","Referentiel:read_R"})
     */
    private $presentation;

    /**
     * @ORM\Column(type="blob", length=255, nullable=true)
     * @Groups({"GroupeApprenant:read_GA","Promo:read_P","Referentiel:read_R"})
     */
    private $programme;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"GroupeApprenant:read_GA","Promo:read_P","Referentiel:read_R"})
     */
    private $critereEvaluation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)

     */
    private $critereAdmission;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetences::class, mappedBy="referentiel")
     * @Groups({"Referentiel:read_R","Promo:read_P","Ref:comp"})
     * @ApiSubresource()
     */
    private $groupeCompetences;

    /**
     * @ORM\OneToMany(targetEntity=Promo::class, mappedBy="referentiel")
     */
    private $promos;

    /**
     * @ORM\OneToMany(targetEntity=Brief::class, mappedBy="referentiel")
     */
    private $briefs;

    /**
     * @ORM\OneToMany(targetEntity=StatistiquesCompetences::class, mappedBy="referentiel")
     */
    private $statistiquesCompetences;

    public function __construct()
    {
        $this->groupeCompetences = new ArrayCollection();
        $this->promos = new ArrayCollection();
        $this->briefs = new ArrayCollection();
        $this->statistiquesCompetences = new ArrayCollection();
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

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getProgramme(): ?string
    {
        return $this->programme;
    }

    public function setProgramme(?string $programme): self
    {
        $this->programme = $programme;

        return $this;
    }

    public function getCritereEvaluation(): ?string
    {
        return $this->critereEvaluation;
    }

    public function setCritereEvaluation(?string $critereEvaluation): self
    {
        $this->critereEvaluation = $critereEvaluation;

        return $this;
    }

    public function getCritereAdmission(): ?string
    {
        return $this->critereAdmission;
    }

    public function setCritereAdmission(?string $critereAdmission): self
    {
        $this->critereAdmission = $critereAdmission;

        return $this;
    }

    /**
     * @return Collection|GroupeCompetences[]
     */
    public function getGroupeCompetences(): Collection
    {
        return $this->groupeCompetences;
    }

    public function addGroupeCompetence(GroupeCompetences $groupeCompetence): self
    {
        if (!$this->groupeCompetences->contains($groupeCompetence)) {
            $this->groupeCompetences[] = $groupeCompetence;
            $groupeCompetence->addReferentiel($this);
        }

        return $this;
    }

    public function removeGroupeCompetence(GroupeCompetences $groupeCompetence): self
    {
        if ($this->groupeCompetences->contains($groupeCompetence)) {
            $this->groupeCompetences->removeElement($groupeCompetence);
            $groupeCompetence->removeReferentiel($this);
        }

        return $this;
    }

    /**
     * @return Collection|Promo[]
     */
    public function getPromos(): Collection
    {
        return $this->promos;
    }

    public function addPromo(Promo $promo): self
    {
        if (!$this->promos->contains($promo)) {
            $this->promos[] = $promo;
            $promo->setReferentiel($this);
        }

        return $this;
    }

    public function removePromo(Promo $promo): self
    {
        if ($this->promos->contains($promo)) {
            $this->promos->removeElement($promo);
            // set the owning side to null (unless already changed)
            if ($promo->getReferentiel() === $this) {
                $promo->setReferentiel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Brief[]
     */
    public function getBriefs(): Collection
    {
        return $this->briefs;
    }

    public function addBrief(Brief $brief): self
    {
        if (!$this->briefs->contains($brief)) {
            $this->briefs[] = $brief;
            $brief->setReferentiel($this);
        }

        return $this;
    }

    public function removeBrief(Brief $brief): self
    {
        if ($this->briefs->contains($brief)) {
            $this->briefs->removeElement($brief);
            // set the owning side to null (unless already changed)
            if ($brief->getReferentiel() === $this) {
                $brief->setReferentiel(null);
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
            $statistiquesCompetence->setReferentiel($this);
        }

        return $this;
    }

    public function removeStatistiquesCompetence(StatistiquesCompetences $statistiquesCompetence): self
    {
        if ($this->statistiquesCompetences->contains($statistiquesCompetence)) {
            $this->statistiquesCompetences->removeElement($statistiquesCompetence);
            // set the owning side to null (unless already changed)
            if ($statistiquesCompetence->getReferentiel() === $this) {
                $statistiquesCompetence->setReferentiel(null);
            }
        }

        return $this;
    }
}
