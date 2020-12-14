<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProfilSortieRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProfilSortieRepository::class)
 * @ApiResource(
 *          normalizationContext={"groups"={"ProfilSortie:read_PS","ProfilSortie:read_all"}},
 *          itemOperations={
 *          "get"={
 *                  "security_post_denormalize"="is_granted('VIEW', object)",
 *                  "security_post_denormalize_message"="Vous n'avez pas ce privilége.",
 *                  "path"="/admin/profilsorties/{id}",
 *                  "defaults"={"id"=null}
 *          },
 *              "getApprenantByProfilSortie"={
 *                      "security_post_denormalize"="is_granted('VIEW', object)",
 *                      "security_post_denormalize_message"="Vous n'avez pas ce privilége.",
 *                      "path"="/admin/promo/{id1}/profilsortie/{id2}",
 *                      "route_name"="getApprenantByProfilSortie"
 *                    }
 *          }
 * )
 */
class ProfilSortie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"ProfilSortie:read_PS"})
     * @Groups({"Promo:read_P","GroupeApprenant:read_GA","Apprenant:read_A"})
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Apprenant::class, mappedBy="profilSortie")
     */
    private $apprenants;

    public function __construct()
    {
        $this->apprenants = new ArrayCollection();
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

    /**
     * @return Collection|Apprenant[]
     */
    public function getApprenants(): Collection
    {
        return $this->apprenants;
    }

    public function addApprenant(Apprenant $apprenant): self
    {
        if (!$this->apprenants->contains($apprenant)) {
            $this->apprenants[] = $apprenant;
            $apprenant->setProfilSortie($this);
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->apprenants->contains($apprenant)) {
            $this->apprenants->removeElement($apprenant);
            // set the owning side to null (unless already changed)
            if ($apprenant->getProfilSortie() === $this) {
                $apprenant->setProfilSortie(null);
            }
        }

        return $this;
    }

}
