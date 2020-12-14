<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ApprenantLivrablePartielRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ApprenantLivrablePartielRepository::class)
 */
class ApprenantLivrablePartiel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity=Apprenant::class, inversedBy="apprenantLivrablePartiels")
     */
    private $apprenant;

    /**
     * @ORM\ManyToOne(targetEntity=LivrablesPartiels::class, inversedBy="apprenantLivrablePartiels")
     */
    private $livrablePartiel;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getApprenant(): ?Apprenant
    {
        return $this->apprenant;
    }

    public function setApprenant(?Apprenant $apprenant): self
    {
        $this->apprenant = $apprenant;

        return $this;
    }

    public function getLivrablePartiel(): ?LivrablesPartiels
    {
        return $this->livrablePartiel;
    }

    public function setLivrablePartiel(?LivrablesPartiels $livrablePartiel): self
    {
        $this->livrablePartiel = $livrablePartiel;

        return $this;
    }
}
