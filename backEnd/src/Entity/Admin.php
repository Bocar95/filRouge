<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AdminRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AdminRepository::class)
 * @ApiResource(
 *      collectionOperations={
 *         "get"={"path"="/admins",
 *                  "access_control"="(is_granted('ROLE_ADMIN'))",
 *                  "access_control_message"="Vous n'avez pas access à cette Ressource",
 *                  "normalization_context"={"groups"={"get_admins:read"}}
 *          },
 *         "post"={"path"="/admin",
 *                 "route_name"="add_admin"
 *          }
 *      },
 *      itemOperations={
 *          "get"={"path"="/admin/{id}",
 *                "requirements"={"id"="\d+"},
 *                "access_control"="(is_granted('ROLE_ADMIN'))",
 *                "access_control_message"="Vous n'avez pas access à cette Ressource",
 *                "normalization_context"={"groups"={"get_admin_by_id:read"}}
 *          },
 *          "put"={"path"="/admin/{id}",
 *                "requirements"={"id"="\d+"},
 *                "access_control"="(is_granted('ROLE_ADMIN'))",
 *                "access_control_message"="Vous n'avez pas access à cette Ressource"
 *          },
 *          "delete"={"path"="/admin/{id}",
 *                "requirements"={"id"="\d+"},
 *                "access_control"="(is_granted('ROLE_ADMIN'))",
 *                "access_control_message"="Vous n'avez pas access à cette Ressource"
 *          }
 *      }
 * )
 */
class Admin extends User
{

    /**
     * @ORM\OneToMany(targetEntity=Promo::class, mappedBy="admin")
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
            $promo->setAdmin($this);
        }

        return $this;
    }

    public function removePromo(Promo $promo): self
    {
        if ($this->promos->removeElement($promo)) {
            // set the owning side to null (unless already changed)
            if ($promo->getAdmin() === $this) {
                $promo->setAdmin(null);
            }
        }

        return $this;
    }
}
