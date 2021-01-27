<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GroupeCompetenceRepository;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

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
 *      "api_add_grpCompetences"={
 *          "method"="post",
 *          "path"="/admin/grpCompetences",
 *          "route_name"="api_add_grpCompetences"
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
 *      "put_grpCompetences"={
 *          "method"="put",
 *          "path"="/admin/grpCompetences/{id}",
 *          "access_control"="(is_granted('ROLE_ADMIN','ROLE_FORMATEUR','ROLE_CM'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource",
 *          "route_name"="put_grpCompetences"
 *      },
 *      "delete"={"path"="/admin/grpCompetences/{id}",
 *          "access_control"="(is_granted('ROLE_ADMIN','ROLE_FORMATEUR','ROLE_CM'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource"
 *      }
 *  }
 * )
 * @ORM\Entity(repositoryClass=GroupeCompetenceRepository::class)
 * @ApiFilter(BooleanFilter::class, properties={"isDeleted"})
 */
class GroupeCompetence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"get_grpCompetences:read","getById_grpCompetences:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *     message = "Ce Champ ne doit pas être vide."
     * )
     * @Groups({"get_grpCompetences:read","getById_grpCompetences:read","get_Referentiels:read"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *     message = "Ce Champ ne doit pas être vide."
     * )
     * @Groups({"get_grpCompetences:read","getById_grpCompetences:read","get_Referentiels:read"})
     */
    private $descriptif;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDeleted = false;

    /**
     * @ORM\ManyToMany(targetEntity=Competence::class, inversedBy="groupeCompetences", cascade="persist")
     * @ApiSubresource()
     * @Groups({"get_grpCompetences:read","getById_grpCompetences:read","get_competences_of_grpCompetence:read","getById_competences_of_grpCompetence:read","get_Referentiels:read"})
     */
    private $competences;

    /**
     * @ORM\ManyToMany(targetEntity=Referentiel::class, mappedBy="groupeCompetences")
     */
    private $referentiels;

    public function __construct()
    {
        $this->competences = new ArrayCollection();
        $this->referentiels = new ArrayCollection();
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

    /**
     * @return Collection|Referentiel[]
     */
    public function getReferentiels(): Collection
    {
        return $this->referentiels;
    }

    public function addReferentiel(Referentiel $referentiel): self
    {
        if (!$this->referentiels->contains($referentiel)) {
            $this->referentiels[] = $referentiel;
            $referentiel->addGroupeCompetence($this);
        }

        return $this;
    }

    public function removeReferentiel(Referentiel $referentiel): self
    {
        if ($this->referentiels->removeElement($referentiel)) {
            $referentiel->removeGroupeCompetence($this);
        }

        return $this;
    }

}
