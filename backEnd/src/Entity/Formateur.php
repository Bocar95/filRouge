<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\FormateurRepository;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=FormateurRepository::class)
 * @ApiResource(
 *      collectionOperations={
 *         "get"={"path"="/formateurs",
 *                  "access_control"="(is_granted('ROLE_ADMIN','ROLE_FORMATEUR'))",
 *                  "access_control_message"="Vous n'avez pas access à cette Ressource",
 *                  "normalization_context"={"groups"={"get_formateurs:read"}}
 *          },
 *         "post"={"path"="/formateur",
 *                 "route_name"="add_formateur"
 *          }
 *      },
 *      itemOperations={
 *          "get"={"path"="/formateur/{id}",
 *                "requirements"={"id"="\d+"},
 *                "access_control"="(is_granted('ROLE_ADMIN','ROLE_FORMATEUR'))",
 *                "access_control_message"="Vous n'avez pas access à cette Ressource",
 *                "normalization_context"={"groups"={"get_formateur_by_id:read"}}
 *          },
 *          "put"={"path"="/formateur/{id}",
 *                "requirements"={"id"="\d+"},
 *                "access_control"="(is_granted('ROLE_ADMIN','ROLE_FORMATEUR'))",
 *                "access_control_message"="Vous n'avez pas access à cette Ressource"
 *          },
 *          "delete"={"path"="/formateur/{id}",
 *                "requirements"={"id"="\d+"},
 *                "access_control"="(is_granted('ROLE_ADMIN','ROLE_FORMATEUR'))",
 *                "access_control_message"="Vous n'avez pas access à cette Ressource"
 *          }
 *      }
 * )
 */
class Formateur  extends User
{

    /**
     * @ORM\ManyToMany(targetEntity=Promo::class, mappedBy="formateurs")
     */
    private $promos;

    public function __construct()
    {
        $this->promos = new ArrayCollection();
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
        if ($this->promos->removeElement($promo)) {
            $promo->removeFormateur($this);
        }

        return $this;
    }
}
