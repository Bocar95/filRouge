<?php

namespace App\Entity;

use App\Entity\Referentiel;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CompetencesRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CompetencesRepository::class)
 * @ApiResource(
 *      normalizationContext={"groups"={"Competences:read_N","Competences:read_all"}},
 *      collectionOperations={
 *                  "get"={"path"="/admin/competences"},
 *                  "post"={
 *                          "security_post_denormalize"="is_granted('EDIT', object)",
 *                          "security_post_denormalize_message"="Vous n'avez pas ce privilége.",
 *                          "path"="/admin/competences"
 *                          }
 *      },
 *      itemOperations={
 *                  "get"={
 *                          "security"="is_granted('VIEW', object)",
 *                          "security_message"="Vous n'avez pas ce privilége.",
 *                          "path"="/admin/competences/{id}",
 *                          "defaults"={"id"=null}
 *                   },
 *                  "put"={
 *                          "security_post_denormalize"="is_granted('EDIT', object)",
 *                          "security_post_denormalize_message"="Vous n'avez pas ce privilége.",
 *                          "path"="/admin/competences/{id}"
 *                   }
 *      }
 * )
 */
class Competences
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"GroupeCompetences:read_M","Competences:read_N","Referentiel:read_R","brief_of_promo","brief_of_groupe_of_promo","brief_broullon_of_formateur","brief_valide_of_formateur","all_briefs","one_brief_of_promo","brief_assigned","Stat_apprenant","Stat_competences","Apprenant_stat","Ref:comp"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *     message = "Ce Champ ne doit pas être vide."
     * )
     * @Groups({"GroupeCompetences:read_M","Competences:read_N","Referentiel:read_R","brief_of_promo","brief_of_groupe_of_promo","brief_broullon_of_formateur","brief_valide_of_formateur","all_briefs","one_brief_of_promo","brief_assigned","GroupeApprenant:read_GA","Stat_apprenant","Stat_competences","Apprenant_stat"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *     message = "Ce Champ ne doit pas être vide."
     * )
     * @Groups({"GroupeCompetences:read_M","Competences:read_N","Referentiel:read_R","brief_of_promo","brief_of_groupe_of_promo","brief_broullon_of_formateur","brief_valide_of_formateur","all_briefs","one_brief_of_promo","brief_assigned","GroupeApprenant:read_GA","Stat_apprenant","Stat_competences","Apprenant_stat"})
     */
    private $descriptif;

    /**
     * @ORM\OneToMany(targetEntity=Niveau::class, mappedBy="competences", cascade="persist")
     * @Groups({"GroupeCompetences:read_M","Competences:read_N","Referentiel:read_R","GroupeApprenant:read_GA","Stat_apprenant","Stat_competences","Apprenant_stat"})
     * @ApiSubresource()
     */
    private $niveau;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetences::class, mappedBy="competences")
     * @Groups({"Competences:read_N"})
     * @Groups({"Niveau:read_NV"})
     */
    private $groupeCompetences;

    /**
     * @ORM\OneToMany(targetEntity=StatistiquesCompetences::class, mappedBy="competence")
     */
    private $statistiquesCompetences;

    public function __construct()
    {
        $this->niveau = new ArrayCollection();
        $this->groupeCompetences = new ArrayCollection();
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

    public function getDescriptif(): ?string
    {
        return $this->descriptif;
    }

    public function setDescriptif(string $descriptif): self
    {
        $this->descriptif = $descriptif;

        return $this;
    }

    /**
     * @return Collection|Niveau[]
     */
    public function getNiveau(): Collection
    {
        return $this->niveau;
    }

    public function addNiveau(Niveau $niveau): self
    {
        if (!$this->niveau->contains($niveau)) {
            $this->niveau[] = $niveau;
            $niveau->setCompetences($this);
        }

        return $this;
    }

    public function removeNiveau(Niveau $niveau): self
    {
        if ($this->niveau->contains($niveau)) {
            $this->niveau->removeElement($niveau);
            // set the owning side to null (unless already changed)
            if ($niveau->getCompetences() === $this) {
                $niveau->setCompetences(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|GroupeCompetences[]
     */
    //public function getGroupeCompetences(): Collection
    //{
    //    return $this->groupeCompetences;
    //}

    public function addGroupeCompetence(GroupeCompetences $groupeCompetence): self
    {
        if (!$this->groupeCompetences->contains($groupeCompetence)) {
            $this->groupeCompetences[] = $groupeCompetence;
            $groupeCompetence->addCompetence($this);
        }

        return $this;
    }

    public function removeGroupeCompetence(GroupeCompetences $groupeCompetence): self
    {
        if ($this->groupeCompetences->contains($groupeCompetence)) {
            $this->groupeCompetences->removeElement($groupeCompetence);
            $groupeCompetence->removeCompetence($this);
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
            $statistiquesCompetence->setCompetence($this);
        }

        return $this;
    }

    public function removeStatistiquesCompetence(StatistiquesCompetences $statistiquesCompetence): self
    {
        if ($this->statistiquesCompetences->contains($statistiquesCompetence)) {
            $this->statistiquesCompetences->removeElement($statistiquesCompetence);
            // set the owning side to null (unless already changed)
            if ($statistiquesCompetence->getCompetence() === $this) {
                $statistiquesCompetence->setCompetence(null);
            }
        }

        return $this;
    }
}
