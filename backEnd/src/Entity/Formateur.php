<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\FormateurRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=FormateurRepository::class)
 * @ApiResource(
 *      normalizationContext={"groups"={"Formateur:read_F","Formateur:read_all"}},
 *       itemOperations={
 *                  "get"={
 *                          "path"="/formateurs/{id}",
 *                          "defaults"={"id"=null}
 *                      },
 *                  "postFormateursLivrablepartielsIdcommentaires"={
 *                              "methods"="post",
 *                              "path"="/formateurs/livrablepartiels/{id}/commentaires",
 *                              "route_name"="apipostFormateursLivrablepartielsIdcommentaires"
 *                            },
 *                  "putFormateursPromoIdBriefIdLivrablepartiels"={
 *                              "methods"="put",
 *                              "path"="/formateurs/promo/{id1}/brief/{id2}/livrablepartiels",
 *                              "route_name"="apiputFormateursPromoIdBriefIdLivrablepartiels"
 *                            },
 *      }
 * )
 */
class Formateur extends User
{
    /**
     * @ORM\ManyToMany(targetEntity=Promo::class, mappedBy="formateurs")
     */
    private $promos;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeApprenant::class, mappedBy="formateurs")
     */
    private $groupeApprenants;

    /**
     * @ORM\OneToMany(targetEntity=Brief::class, mappedBy="formateur")
     * @Groups({"Formateur:read_F"})
     */
    private $briefs;

    /**
     * @ORM\OneToMany(targetEntity=Commentaires::class, mappedBy="formateur")
     * @Groups({"Formateur:read_F"})
     */
    private $commentaires;

    public function __construct()
    {
        $this->promos = new ArrayCollection();
        $this->groupeApprenants = new ArrayCollection();
        $this->briefs = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $promo->addFormateur($this);
        }

        return $this;
    }

    public function removePromo(Promo $promo): self
    {
        if ($this->promos->contains($promo)) {
            $this->promos->removeElement($promo);
            $promo->removeFormateur($this);
        }

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
            $groupeApprenant->addFormateur($this);
        }

        return $this;
    }

    public function removeGroupeApprenant(GroupeApprenant $groupeApprenant): self
    {
        if ($this->groupeApprenants->contains($groupeApprenant)) {
            $this->groupeApprenants->removeElement($groupeApprenant);
            $groupeApprenant->removeFormateur($this);
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
            $brief->setFormateur($this);
        }

        return $this;
    }

    public function removeBrief(Brief $brief): self
    {
        if ($this->briefs->contains($brief)) {
            $this->briefs->removeElement($brief);
            // set the owning side to null (unless already changed)
            if ($brief->getFormateur() === $this) {
                $brief->setFormateur(null);
            }
        }

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
            $commentaire->setFormateur($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaires $commentaire): self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getFormateur() === $this) {
                $commentaire->setFormateur(null);
            }
        }

        return $this;
    }

}
