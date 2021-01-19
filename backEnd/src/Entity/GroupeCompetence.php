<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GroupeCompetenceRepository;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *  collectionOperations={
 *      "get"={"path"="/admin/grpCompetences",
 *          "access_control"="(is_granted('ROLE_ADMIN','ROLE_FORMATEUR','ROLE_CM'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource",
 *          "normalization_context"={"groups"={"get_grpCompetences:read"}}
 *      },
 *      "get_competences"={
 *          "method"="get",
 *          "path"="/admin/grpCompetences/competences",
 *          "access_control"="(is_granted('ROLE_ADMIN','ROLE_FORMATEUR','ROLE_CM'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource",
 *          "normalization_context"={"groups"={"get_competences_of_grpCompetence:read"}}
 *      },
 *      "post"={"path"="/admin/grpCompetences",
 *          "access_control"="(is_granted('ROLE_ADMIN','ROLE_FORMATEUR','ROLE_CM'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource"
 *      }
 *  },
 *  itemOperations={
 *      "get"={"path"="/admin/grpCompetences/{id}",
 *          "access_control"="(is_granted('ROLE_ADMIN','ROLE_FORMATEUR','ROLE_CM'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource",
 *          "normalization_context"={"groups"={"getById_grpCompetences:read"}}
 *      },
 *      "getById_competences"={
 *          "method"="get",
 *          "path"="/admin/grpCompetences/{id}/competences",
 *          "access_control"="(is_granted('ROLE_ADMIN','ROLE_FORMATEUR','ROLE_CM'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource",
 *          "normalization_context"={"groups"={"getById_competences_of_grpCompetence:read"}}
 *      },
 *      "put"={"path"="/admin/grpCompetences/{id}",
 *          "access_control"="(is_granted('ROLE_ADMIN','ROLE_FORMATEUR','ROLE_CM'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource",
 *          "normalization_context"={"groups"={"put_grpCompetences:read"}}
 *      },
 *      "delete"={"path"="/admin/grpCompetences/{id}",
 *          "access_control"="(is_granted('ROLE_ADMIN','ROLE_FORMATEUR','ROLE_CM'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource"
 *      }
 *  }
 * )
 * @ORM\Entity(repositoryClass=GroupeCompetenceRepository::class)
 */
class GroupeCompetence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get_grpCompetences:read","getById_grpCompetences:read","put_grpCompetences:read"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get_grpCompetences:read","getById_grpCompetences:read","put_grpCompetences:read"})
     */
    private $descriptif;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDeleted = false;

    /**
     * @ORM\ManyToMany(targetEntity=Competence::class, inversedBy="groupeCompetences")
     * @ApiSubresource()
     * @Groups({"get_competences_of_grpCompetence:read","getById_competences_of_grpCompetence:read"})
     */
    private $competences;

    public function __construct()
    {
        $this->competences = new ArrayCollection();
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
     * @return Collection|Competence[]
     */
    public function getCompetences(): Collection
    {
        return $this->competences;
    }

    public function addCompetence(Competence $competence): self
    {
        if (!$this->competences->contains($competence)) {
            $this->competences[] = $competence;
        }

        return $this;
    }

    public function removeCompetence(Competence $competence): self
    {
        $this->competences->removeElement($competence);

        return $this;
    }

}
