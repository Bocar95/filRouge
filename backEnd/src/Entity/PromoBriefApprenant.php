<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\PromoBriefApprenantRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=PromoBriefApprenantRepository::class)
 */
class PromoBriefApprenant
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Brief:app_read"})
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity=Apprenant::class, inversedBy="promoBriefApprenant")
     * @Groups({"Brief:app_read"})
     */
    private $apprenant;

    /**
     * @ORM\ManyToOne(targetEntity=PromoBrief::class, inversedBy="promoBriefApprenant")
     * @Groups({"Brief:app_read"})
     */
    private $promoBrief;

    public function __construct()
    {
        $this->apprenants = new ArrayCollection();
        $this->promoBriefs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
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

    public function getPromoBrief(): ?PromoBrief
    {
        return $this->promoBrief;
    }

    public function setPromoBrief(?PromoBrief $promoBrief): self
    {
        $this->promoBrief = $promoBrief;

        return $this;
    }

 
}
