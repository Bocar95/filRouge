<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\GroupeTagRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=GroupeTagRepository::class)
 * @ApiResource(
 *      normalizationContext={"groups"={"GroupeTag:read_GT","GroupeTag:read_all"}},
 *      collectionOperations={
 *                  "get"={"path"="/admin/grptags"},
 *                  "post"={
 *                          "security_post_denormalize"="is_granted('EDIT', object)",
 *                          "security_post_denormalize_message"="Vous n'avez pas ce privilége.",
 *                          "path"="/admin/grptags"
 *                          }
 *      },
 *      itemOperations={
 *                  "get"={
 *                          "security"="is_granted('VIEW', object)",
 *                          "security_message"="Vous n'avez pas ce privilége.",
 *                          "path"="/admin/grptags/{id}",
 *                          "defaults"={"id"=null}
 *                   },
 *                  "put"={
 *                          "security_post_denormalize"="is_granted('EDIT', object)",
 *                          "security_post_denormalize_message"="Vous n'avez pas ce privilége.",
 *                          "path"="/admin/grptags/{id}"
 *                   }
 *      }
 * )
 */
class GroupeTag
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"GroupeTag:read_GT"})
     * @Groups({"Tag:read_T"})
     */
    private $libelle;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="groupeTags")
     */
    private $tag;

    /**
     * @ORM\ManyToMany(targetEntity=Admin::class, inversedBy="groupeTags")
     */
    private $admin;

    public function __construct()
    {
        $this->tag = new ArrayCollection();
        $this->admin = new ArrayCollection();
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

    /**
     * @return Collection|Tag[]
     */
    public function getTag(): Collection
    {
        return $this->tag;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tag->contains($tag)) {
            $this->tag[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tag->contains($tag)) {
            $this->tag->removeElement($tag);
        }

        return $this;
    }

    /**
     * @return Collection|Admin[]
     */
    public function getAdmin(): Collection
    {
        return $this->admin;
    }

    public function addAdmin(Admin $admin): self
    {
        if (!$this->admin->contains($admin)) {
            $this->admin[] = $admin;
        }

        return $this;
    }

    public function removeAdmin(Admin $admin): self
    {
        if ($this->admin->contains($admin)) {
            $this->admin->removeElement($admin);
        }

        return $this;
    }
}
