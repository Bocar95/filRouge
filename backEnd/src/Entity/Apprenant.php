<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ApprenantRepository;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=ApprenantRepository::class)
 * @ApiResource(
 *      collectionOperations={
 *         "get"={"path"="/apprenants",
 *                  "access_control"="(is_granted('ROLE_ADMIN','ROLE_FORMATEUR','ROLE_CM'))",
 *                  "access_control_message"="Vous n'avez pas access à cette Ressource",
 *                  "normalization_context"={"groups"={"get_apprenants:read"}}
 *          },
 *         "post"={"path"="/apprenant",
 *                 "route_name"="add_apprenant"
 *          }
 *      },
 *      itemOperations={
 *          "get"={"path"="/apprenant/{id}",
 *                "requirements"={"id"="\d+"},
 *                "access_control"="(is_granted('ROLE_ADMIN','ROLE_FORMATEUR','ROLE_CM'))",
 *                "access_control_message"="Vous n'avez pas access à cette Ressource",
 *                "normalization_context"={"groups"={"get_apprenant_by_id:read"}}
 *          },
 *          "put"={"path"="/apprenant/{id}",
 *                "requirements"={"id"="\d+"},
 *                "access_control"="(is_granted('ROLE_ADMIN','ROLE_FORMATEUR'))",
 *                "access_control_message"="Vous n'avez pas access à cette Ressource"
 *          },
 *          "delete"={"path"="/apprenant/{id}",
 *                "requirements"={"id"="\d+"},
 *                "access_control"="(is_granted('ROLE_ADMIN','ROLE_FORMATEUR'))",
 *                "access_control_message"="Vous n'avez pas access à cette Ressource"
 *          }
 *      }
 * )
 */
class Apprenant extends User
{

    /**
     * @ORM\ManyToMany(targetEntity=GroupeApprenants::class, mappedBy="apprenants")
     */
    private $groupeApprenants;

    public function __construct()
    {
        $this->groupeApprenants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|GroupeApprenants[]
     */
    public function getGroupeApprenants(): Collection
    {
        return $this->groupeApprenants;
    }

    public function addGroupeApprenant(GroupeApprenants $groupeApprenant): self
    {
        if (!$this->groupeApprenants->contains($groupeApprenant)) {
            $this->groupeApprenants[] = $groupeApprenant;
            $groupeApprenant->addApprenant($this);
        }

        return $this;
    }

    public function removeGroupeApprenant(GroupeApprenants $groupeApprenant): self
    {
        if ($this->groupeApprenants->removeElement($groupeApprenant)) {
            $groupeApprenant->removeApprenant($this);
        }

        return $this;
    }
}
