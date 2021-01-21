<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CompetenceRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ApiResource(
 * collectionOperations={
 *      "get"={"path"="/admin/competences",
 *          "access_control"="(is_granted('ROLE_ADMIN','ROLE_FORMATEUR','ROLE_CM'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource",
 *          "normalization_context"={"groups"={"get_competences:read"}}
 *      },
 *      "api_add_competences"={
 *          "method"="post",
 *          "path"="/admin/competences",
 *          "route_name"="api_add_competences"
 *      }
 *  },
 *  itemOperations={
 *      "get"={"path"="/admin/competences/{id}",
 *          "access_control"="(is_granted('ROLE_ADMIN','ROLE_FORMATEUR','ROLE_CM'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource",
 *          "normalization_context"={"groups"={"getById_competences:read"}}
 *      },
 *      "put"={"path"="/admin/competences/{id}",
 *          "access_control"="(is_granted('ROLE_ADMIN','ROLE_FORMATEUR','ROLE_CM'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource"
 *      },
 *      "delete"={"path"="/admin/competences/{id}",
 *          "access_control"="(is_granted('ROLE_ADMIN','ROLE_FORMATEUR','ROLE_CM'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource"
 *      }
 *  }
 * )
 * @ORM\Entity(repositoryClass=CompetenceRepository::class)
 * @ApiFilter(BooleanFilter::class, properties={"isDeleted"})
 */
class Competence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"get_competences:read", "getById_competences:read", "getById_grpCompetences:read","get_competences_of_grpCompetence:read","getById_competences_of_grpCompetence:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *     message = "Ce Champ ne doit pas être vide."
     * )
     * @Groups({"get_competences:read", "getById_competences:read", "getById_grpCompetences:read","get_competences_of_grpCompetence:read","getById_competences_of_grpCompetence:read","put_grpCompetences"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *     message = "Ce Champ ne doit pas être vide."
     * )
     * @Groups({"get_competences:read", "getById_competences:read", "getById_grpCompetences:read","get_competences_of_grpCompetence:read","getById_competences_of_grpCompetence:read","put_grpCompetences"})
     */
    private $descriptif;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDeleted = false;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetence::class, mappedBy="competences")
     */
    private $groupeCompetences;

    /**
     * @ORM\OneToMany(targetEntity=NiveauCompetence::class, mappedBy="competences", cascade="persist")
     */
    private $niveauCompetences;

    public function __construct()
    {
        $this->groupeCompetences = new ArrayCollection();
        $this->niveauCompetences = new ArrayCollection();
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
     * @return Collection|GroupeCompetence[]
     */
    public function getGroupeCompetences(): Collection
    {
        return $this->groupeCompetences;
    }

    public function addGroupeCompetence(GroupeCompetence $groupeCompetence): self
    {
        if (!$this->groupeCompetences->contains($groupeCompetence)) {
            $this->groupeCompetences[] = $groupeCompetence;
            $groupeCompetence->addCompetence($this);
        }

        return $this;
    }

    public function removeGroupeCompetence(GroupeCompetence $groupeCompetence): self
    {
        if ($this->groupeCompetences->removeElement($groupeCompetence)) {
            $groupeCompetence->removeCompetence($this);
        }

        return $this;
    }

    /**
     * @return Collection|NiveauCompetence[]
     */
    public function getNiveauCompetences(): Collection
    {
        return $this->niveauCompetences;
    }

    public function addNiveauCompetence(NiveauCompetence $niveauCompetence): self
    {
        if (!$this->niveauCompetences->contains($niveauCompetence)) {
            $this->niveauCompetences[] = $niveauCompetence;
            $niveauCompetence->setCompetences($this);
        }

        return $this;
    }

    public function removeNiveauCompetence(NiveauCompetence $niveauCompetence): self
    {
        if ($this->niveauCompetences->removeElement($niveauCompetence)) {
            // set the owning side to null (unless already changed)
            if ($niveauCompetence->getCompetences() === $this) {
                $niveauCompetence->setCompetences(null);
            }
        }

        return $this;
    }

}
