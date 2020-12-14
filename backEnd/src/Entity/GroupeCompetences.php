<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\GroupeCompetencesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=GroupeCompetencesRepository::class)
 * @ApiResource(
 *      normalizationContext={"groups"={"GroupeCompetences:read_M","GroupeCompetences:read_all"}},
 *      denormalizationContext={"groups"={"GroupeCompetences:write"}},
 *      collectionOperations={
 *                  "get"={"path"="/admin/grpCompetences"},
 *                  "getGrpCompetences"={"methods"="get",
 *                                     "path"="/admin/grpCompetences/competences",
 *                                     "route_name"="apiGetGrpCompCompetences"
 *                                      },
 *                  "post"={
 *                          "security_post_denormalize"="is_granted('EDIT', object)",
 *                          "security_post_denormalize_message"="Vous n'avez pas ce privilége.",
 *                          "path"="/admin/grpCompetences"
 *                          }
 *      },
 *      itemOperations={
 *                  "get"={
 *                          "security"="is_granted('VIEW', object)",
 *                          "security_message"="Vous n'avez pas ce privilége.",
 *                          "path"="/admin/grpCompetences/{id}",
 *                          "defaults"={"id"=null}
 *                          },
 *                  "getGrpIdCompetences"={"methods"="get",
 *                                     "path"="/admin/grpCompetences/{id}/competences",
 *                                     "defaults"={"id"=null},
 *                                     "route_name"="apiGetGrpIdCompetences"
 *                      },
 *                  "put"={
 *                          "security_post_denormalize"="is_granted('EDIT', object)",
 *                          "security_post_denormalize_message"="Vous n'avez pas ce privilége.",
 *                          "path"="/admin/grpCompetences/{id}",
 *                          "defaults"={"id"=null}
 *                         }
 *      }
 * )
 */
class GroupeCompetences
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"GroupeCompetences:read_M"})
     * @Groups({"Referentiel:read_R"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"GroupeCompetences:read_M"})
     * @Groups({"Referentiel:read_R"})
     * @Groups({"GroupeApprenant:read_GA"})
     * @Groups({"Tag:read_T"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"GroupeCompetences:read_M"})
     * @Groups({"Referentiel:read_R"})
     * @Groups({"GroupeApprenant:read_GA"})
     * @Groups({"Tag:read_T"})
     */
    private $descriptif;

    /**
     * @ORM\ManyToMany(targetEntity=Competences::class, inversedBy="groupeCompetences", cascade="persist")
     * @Groups({"GroupeCompetences:read_M","GroupeCompetences:write","Ref:comp"})
     * @Groups({"Referentiel:read_R"})
     * @Groups({"GroupeApprenant:read_GA"})
     * @Groups({"Tag:read_T"})
     * @ApiSubresource()
     */
    private $competences;

    /**
     * @ORM\ManyToMany(targetEntity=Referentiel::class, inversedBy="groupeCompetences")
     * @Groups({"GroupeCompetences:read_M"})
     * @ApiSubresource()
     */
    private $referentiel;

    /**
     * @ORM\ManyToOne(targetEntity=Admin::class, inversedBy="groupeCompetences")
     * @Groups({"Referentiel:read_R"})
     * @ApiSubresource()
     */
    private $admin;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="groupeCompetences")
     * @Groups({"GroupeCompetences:read_M"})
     */
    private $tag;

    public function __construct()
    {
        $this->competences = new ArrayCollection();
        $this->referentiel = new ArrayCollection();
        $this->tag = new ArrayCollection();
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

    public function setDescriptif(?string $descriptif): self
    {
        $this->descriptif = $descriptif;

        return $this;
    }

    /**
     * @return Collection|Competences[]
     */
    public function getCompetences(): Collection
    {
        return $this->competences;
    }


    public function addCompetence(Competences $competence): self
    {
        if (!$this->competences->contains($competence)) {
            $this->competences[] = $competence;
        }
        return $this;
    }

    public function removeCompetence(Competences $competence): self
    {
        if ($this->competences->contains($competence)) {
            $this->competences->removeElement($competence);
        }

        return $this;
    }

    /**
     * @return Collection|Referentiel[]
     */
    //public function getReferentiel(): Collection
    //{
    //    return $this->referentiel;
    //}

    public function addReferentiel(Referentiel $referentiel): self
    {
        if (!$this->referentiel->contains($referentiel)) {
            $this->referentiel[] = $referentiel;
        }

        return $this;
    }

    public function removeReferentiel(Referentiel $referentiel): self
    {
        if ($this->referentiel->contains($referentiel)) {
            $this->referentiel->removeElement($referentiel);
        }

        return $this;
    }

    public function getAdmin(): ?Admin
    {
        return $this->admin;
    }

    public function setAdmin(?Admin $admin): self
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTag(): Collection
    {
        return $this->tag;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tag->contains($tag)) {
            $this->tag[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tag->contains($tag)) {
            $this->tag->removeElement($tag);
        }

        return $this;
    }

}
