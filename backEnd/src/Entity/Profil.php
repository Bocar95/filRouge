<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProfilRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ProfilRepository::class)
 * @UniqueEntity("libelle",message="Ce libellé est déja utilisé.")
 * @ApiResource(
 *      collectionOperations={
 *         "get"={"path"="/admin/profils",
 *                  "access_control"="(is_granted('ROLE_ADMIN'))",
 *                  "access_control_message"="Vous n'avez pas access à cette Ressource",
 *                  "normalization_context"={"groups"={"profil:read"}}
 *                },
 *         "post"={"path"="/admin/profils",
 *                  "access_control"="(is_granted('ROLE_ADMIN'))",
 *                  "access_control_message"="Vous n'avez pas access à cette Ressource"
 *                }
 *     },
 *       itemOperations={
 *         "get"={"path"="/admin/profils/{id}",
 *                  "requirements"={"id"="\d+"},
 *                  "access_control"="(is_granted('ROLE_ADMIN'))",
 *                  "access_control_message"="Vous n'avez pas access à cette Ressource"
 *          },
 *         "put"={"path"="/admin/profils/{id}",
 *                  "requirements"={"id"="\d+"},
 *                  "access_control"="(is_granted('ROLE_ADMIN'))",
 *                  "access_control_message"="Vous n'avez pas access à cette Ressource"
 *          },
 *         "delete"={"path"="/admin/profils/{id}",
 *                  "requirements"={"id"="\d+"},
 *                  "access_control"="(is_granted('ROLE_ADMIN'))",
 *                  "access_control_message"="Vous n'avez pas access à cette Ressource"
 *          }
 *     }
 * )
 * @ApiFilter(BooleanFilter::class, properties={"isDeleted"})
 */
class Profil
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"profil:read" })
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"profil:read","user:read","get_admins:read","get_admin_by_id:read","get_apprenants:read","get_apprenant_by_id:read","get_formateurs:read","get_formateur_by_id:read","get_cm:read","get_cm_by_id:read"})
     * @Assert\NotBlank(
     *     message = "Ce Champ ne doit pas être vide."
     * )
     */
    private $libelle;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"profil:read" })
     */
    private $isDeleted = false;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="profil")
     * @Groups({"users_profil:read"})
     * @ApiSubresource()
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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
        $this->libelle = mb_strtoupper($libelle);

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
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setProfil($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getProfil() === $this) {
                $user->setProfil(null);
            }
        }

        return $this;
    }
}
