<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\NiveauCompetenceRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ApiResource(
 *  collectionOperations={
 *      "get"={"path"="/admin/niveaux",
 *          "access_control"="(is_granted('ROLE_ADMIN','ROLE_FORMATEUR','ROLE_CM'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource",
 *          "normalization_context"={"groups"={"get_niveaux:read"}}
 *      }
 *  }
 * )
 * @ORM\Entity(repositoryClass=NiveauCompetenceRepository::class)
 * @ApiFilter(BooleanFilter::class, properties={"isDeleted"})
 * @UniqueEntity("libelle",message="Ce libellé existe déja.")
 */
class NiveauCompetence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"get_niveaux:read","get_competences:read", "getById_competences:read", "getById_grpCompetences:read","get_competences_of_grpCompetence:read","getById_competences_of_grpCompetence:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get_niveaux:read","get_competences:read", "getById_competences:read", "getById_grpCompetences:read","get_competences_of_grpCompetence:read","getById_competences_of_grpCompetence:read"})
     */
    private $libelle;

    /**
     * @ORM\ManyToOne(targetEntity=Competence::class, inversedBy="niveauCompetences")
     */
    private $competences;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get_niveaux:read","get_competences:read", "getById_competences:read", "getById_grpCompetences:read","get_competences_of_grpCompetence:read","getById_competences_of_grpCompetence:read"})
     */
    private $critereEvaluation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get_niveaux:read","get_competences:read", "getById_competences:read", "getById_grpCompetences:read","get_competences_of_grpCompetence:read","getById_competences_of_grpCompetence:read"})
     */
    private $groupeAction;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDeleted = false;

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

    public function getCompetences(): ?Competence
    {
        return $this->competences;
    }

    public function setCompetences(?Competence $competences): self
    {
        $this->competences = $competences;

        return $this;
    }

    public function getCritereEvaluation(): ?string
    {
        return $this->critereEvaluation;
    }

    public function setCritereEvaluation(string $critereEvaluation): self
    {
        $this->critereEvaluation = $critereEvaluation;

        return $this;
    }

    public function getGroupeAction(): ?string
    {
        return $this->groupeAction;
    }

    public function setGroupeAction(string $groupeAction): self
    {
        $this->groupeAction = $groupeAction;

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
}
