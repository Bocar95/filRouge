<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 * @ApiResource(
 *      normalizationContext={"groups"={"Tag:read_T","Tag:read_all"}},
 *      collectionOperations={
 *                  "get"={"path"="/admin/tags"},
 *                  "post"={
 *                          "security_post_denormalize"="is_granted('EDIT', object)",
 *                          "security_post_denormalize_message"="Vous n'avez pas ce privilége.",
 *                          "path"="/admin/tags"
 *                          }
 *      },
 *      itemOperations={
 *                  "get"={
 *                          "security"="is_granted('VIEW', object)",
 *                          "security_message"="Vous n'avez pas ce privilége.",
 *                          "path"="/admin/tags/{id}",
 *                          "defaults"={"id"=null}
 *                   },
 *                  "put"={
 *                          "security_post_denormalize"="is_granted('EDIT', object)",
 *                          "security_post_denormalize_message"="Vous n'avez pas ce privilége.",
 *                          "path"="/admin/tags/{id}"
 *                   }
 *      }
 * )
 */
class Tag
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Tag:read_T","brief_of_promo","brief_of_groupe_of_promo","brief_broullon_of_formateur","brief_valide_of_formateur","one_brief_of_promo","brief_assigned","all_briefs"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Tag:read_T","brief_of_promo","brief_of_groupe_of_promo","brief_broullon_of_formateur","brief_valide_of_formateur","one_brief_of_promo","brief_assigned","all_briefs"})
     */
    private $descriptif;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeTag::class, mappedBy="tag")
     * @Groups({"Tag:read_T"})
     */
    private $groupeTags;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetences::class, mappedBy="tag")
     * @Groups({"Tag:read_T"})
     */
    private $groupeCompetences;

    /**
     * @ORM\ManyToMany(targetEntity=Brief::class, mappedBy="tag")
     */
    private $briefs;

    public function __construct()
    {
        $this->groupeTags = new ArrayCollection();
        $this->groupeCompetences = new ArrayCollection();
        $this->briefs = new ArrayCollection();
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
     * @return Collection|GroupeTag[]
     */
    public function getGroupeTags(): Collection
    {
        return $this->groupeTags;
    }

    public function addGroupeTag(GroupeTag $groupeTag): self
    {
        if (!$this->groupeTags->contains($groupeTag)) {
            $this->groupeTags[] = $groupeTag;
            $groupeTag->addTag($this);
        }

        return $this;
    }

    public function removeGroupeTag(GroupeTag $groupeTag): self
    {
        if ($this->groupeTags->contains($groupeTag)) {
            $this->groupeTags->removeElement($groupeTag);
            $groupeTag->removeTag($this);
        }

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
            $groupeCompetence->addTag($this);
        }

        return $this;
    }

    public function removeGroupeCompetence(GroupeCompetences $groupeCompetence): self
    {
        if ($this->groupeCompetences->contains($groupeCompetence)) {
            $this->groupeCompetences->removeElement($groupeCompetence);
            $groupeCompetence->removeTag($this);
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
            $brief->addTag($this);
        }

        return $this;
    }

    public function removeBrief(Brief $brief): self
    {
        if ($this->briefs->contains($brief)) {
            $this->briefs->removeElement($brief);
            $brief->removeTag($this);
        }

        return $this;
    }

}
