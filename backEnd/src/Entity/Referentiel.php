<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReferentielRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ORM\Entity(repositoryClass=ReferentielRepository::class)
 * @ApiResource(
 *      collectionOperations={
 *          "get"={
 *              "path"="/admin/referentiels",
 *              "access_control"="(is_granted('ROLE_ADMIN','ROLE_FORMATEUR','ROLE_CM'))",
 *              "access_control_message"="Vous n'avez pas access à cette Ressource",
 *              "normalization_context"={"groups"={"get_Referentiels:read"}}
 *          },
 *          "post"={
 *              "path"="/admin/referentiels",
 *              "route_name"="api_add_referentiels"
 *          }
 *      },
 *      itemOperations={
 *          "get"={
 *              "security_post_denormalize"="is_granted('VIEW', object)",
 *              "security_post_denormalize_message"="Vous n'avez pas ce privilége.",
 *              "path"="/admin/referentiels/{id}",
 *              "normalization_context"={"groups"={"get_RefById"}}
 *          },
 *          "get_GrpCompOfRefById"={
 *              "method"="get",
 *              "path"="/admin/referentiels/{id}/groupecompetences",
 *              "normalization_context"={"groups"={"get_GrpCompOfRefById:read"}}
 *           },
 *          "get_CompOfGrpCompByIdOfRefById"={
 *              "method"="get",
 *              "path"="/admin/referentiels/{id}/grpecompetences/{id2}",
 *              "route_name"="get_CompOfGrpCompByIdOfRefById"
 *           },
 *           "put"={
 *              "path"="/admin/referentiels/{id}",
 *              "route_name"="put_Referentiel"
 *            },
 *           "delete"={
 *              "path"="/admin/referentiels/{id}"
 *            }
 *      }
 * )
 * @ApiFilter(BooleanFilter::class, properties={"isDeleted"})
 */
class Referentiel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"get_Referentiels:read","getPromos:read","get_RefById","get_RefByIdPromo:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get_Referentiels:read","getPromos:read","get_RefById","get_RefByIdPromo:read"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get_Referentiels:read","getPromos:read","get_RefById","get_RefByIdPromo:read"})
     */
    private $presentation;

    /**
     * @ORM\Column(type="blob", nullable=true)
     * @Groups({"get_Referentiels:read","getPromos:read","get_RefById","get_RefByIdPromo:read"})
     */
    private $programme;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get_Referentiels:read","getPromos:read","get_RefById","get_RefByIdPromo:read"})
     */
    private $critereEvaluation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get_Referentiels:read","getPromos:read","get_RefById","get_RefByIdPromo:read"})
     */
    private $critereAdmission;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDeleted = false;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetence::class, inversedBy="referentiels")
     * @ApiSubresource()
     * @Groups({"get_Referentiels:read","get_GrpCompOfRefById:read","get_RefById","get_CompOfGrpCompByIdOfRefById:read","getPromos:read","get_RefByIdPromo:read"})
     */
    private $groupeCompetences;

    /**
     * @ORM\OneToMany(targetEntity=Promo::class, mappedBy="referentiel")
     */
    private $promos;

    public function __construct()
    {
        $this->groupeCompetences = new ArrayCollection();
        $this->promos = new ArrayCollection();
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

    public function getProgramme()
    {
        return $this->programme;
    }

    public function setProgramme($programme): self
    {
        $this->programme = $programme;

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

    public function getCritereAdmission(): ?string
    {
        return $this->critereAdmission;
    }

    public function setCritereAdmission(string $critereAdmission): self
    {
        $this->critereAdmission = $critereAdmission;

        return $this;
    }


    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * @return Collection|groupeCompetence[]
     */
    public function getGroupeCompetences(): Collection
    {
        return $this->groupeCompetences;
    }

    public function addGroupeCompetence(groupeCompetence $groupeCompetence): self
    {
        if (!$this->groupeCompetences->contains($groupeCompetence)) {
            $this->groupeCompetences[] = $groupeCompetence;
        }

        return $this;
    }

    public function removeGroupeCompetence(groupeCompetence $groupeCompetence): self
    {
        $this->groupeCompetences->removeElement($groupeCompetence);

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
        if ($this->promos->removeElement($promo)) {
            // set the owning side to null (unless already changed)
            if ($promo->getReferentiel() === $this) {
                $promo->setReferentiel(null);
            }
        }

        return $this;
    }

}
