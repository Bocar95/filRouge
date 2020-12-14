<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\RessourceRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=RessourceRepository::class)
 */
class Ressource
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"brief_of_promo","brief_of_groupe_of_promo","brief_broullon_of_formateur","brief_valide_of_formateur","one_brief_of_promo","brief_assigned","all_briefs"})
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"brief_of_promo","brief_of_groupe_of_promo","brief_broullon_of_formateur","brief_valide_of_formateur","one_brief_of_promo","brief_assigned","all_briefs"})
     */
    private $url;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $pieceJointe;

    /**
     * @ORM\ManyToOne(targetEntity=Brief::class, inversedBy="ressource")
     */
    private $brief;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getPieceJointe()
    {
        return $this->pieceJointe;
    }

    public function setPieceJointe($pieceJointe): self
    {
        $this->pieceJointe = $pieceJointe;

        return $this;
    }

    public function getBrief(): ?Brief
    {
        return $this->brief;
    }

    public function setBrief(?Brief $brief): self
    {
        $this->brief = $brief;

        return $this;
    }

}
