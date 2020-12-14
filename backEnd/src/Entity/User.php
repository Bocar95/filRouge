<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Profil;
use Doctrine\ORM\Mapping\InheritanceType;
use ApiPlatform\Core\Action\NotFoundAction;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Symfony\Component\Security\Core\Security;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;
use Symfony\Component\Serializer\Annotation\DiscriminatorMap;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"user" = "User", "admin"="Admin", "formateur" = "Formateur", "apprenant" = "Apprenant", "cm"="Cm"})
 * @UniqueEntity("email",message="Cette adresse mail est déja utilisé.")
 * @ApiResource(
 *     collectionOperations={
 *         "get"={"path"="/admin/users"},
 *         "post"={"path"="/admin/users"},
 *          "get_apprenants"={"method"="get",
 *                            "path"="/apprenants"}
 *     },
 *     itemOperations={
 *         "get"={"path"="/admin/users/{id}",
 *                "requirements"={"id"="\d+"}
 *          },
 *         "put"={"path"="/admin/users/{id}",
 *                "requirements"={"id"="\d+"}
 *          }
 *     }
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"user:read", "user:write","Promo:read_P","brief_of_groupe_of_promo","brief_broullon_of_formateur","brief_valide_of_formateur","one_brief_of_promo","brief_assigned","all_briefs","Formateur:read_F","GroupeApprenant:read_GA","Apprenant:read_A","Stat_apprenant","App_check_stat_brief"})
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(
     *     message = "Ce Champ ne doit pas être vide."
     * )
     * @Groups({"user:read", "user:write","Brief:app_read"})
     */
    protected $username;

    protected $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(
     *     message = "Ce Champ ne doit pas être vide."
     * )
     * @Groups({"user:read", "user:write"})
     */
    protected $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *     message = "Ce Champ ne doit pas être vide."
     * )
     * @Groups({"user:read", "user:write","Promo:read_P","brief_of_groupe_of_promo","brief_broullon_of_formateur","brief_valide_of_formateur","one_brief_of_promo","brief_assigned","all_briefs","brief_of_promo","Formateur:read_F","GroupeApprenant:read_GA","Apprenant:read_A","Stat_apprenant","Apprenant_stat"})
     */
    protected $email;

    /**
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="users")
     * @Groups({"user:read", "user:write"})
     * @ApiSubresource()
     */
    protected $profil;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *     message = "Ce Champ ne doit pas être vide."
     * )
     * @Groups({"user:read", "user:write","brief_of_promo","Promo:read_P","brief_of_groupe_of_promo","brief_broullon_of_formateur","brief_valide_of_formateur","one_brief_of_promo","brief_assigned","all_briefs","Formateur:read_F","GroupeApprenant:read_GA","Apprenant:read_A","Stat_apprenant","Apprenant_stat"})
     */
    protected $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *     message = "Ce Champ ne doit pas être vide."
     * )
     * @Groups({"user:read", "user:write","brief_of_promo","Promo:read_P","brief_of_groupe_of_promo","brief_broullon_of_formateur","brief_valide_of_formateur","one_brief_of_promo","brief_assigned","all_briefs","Formateur:read_F","GroupeApprenant:read_GA","Apprenant:read_A","Stat_apprenant","Apprenant_stat"})
     */
    protected $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *     message = "Ce Champ ne doit pas être vide."
     * )
     * @Groups({"user:read", "user:write","brief_of_promo","Promo:read_P","brief_of_groupe_of_promo","brief_broullon_of_formateur","brief_valide_of_formateur","one_brief_of_promo","brief_assigned","all_briefs","Formateur:read_F","GroupeApprenant:read_GA","Apprenant:read_A"})
     */
    protected $adresse;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"Promo:read_P","GroupeApprenant:read_GA","Apprenant:read_A"})
     */
    protected $isConnected;

    /**
     * @ORM\OneToMany(targetEntity=CommentaireGeneral::class, mappedBy="user")
     */
    private $commentaireGenerals;

    public function __construct()
    {
        $this->commentaireGenerals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_'.$this->profil->getLibelle();

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): self
    {
        $this->profil = $profil;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getIsConnected(): ?bool
    {
        return $this->isConnected;
    }

    public function setIsConnected(bool $isConnected): self
    {
        $this->isConnected = $isConnected;

        return $this;
    }

    /**
     * @return Collection|CommentaireGeneral[]
     */
    public function getCommentaireGenerals(): Collection
    {
        return $this->commentaireGenerals;
    }

    public function addCommentaireGeneral(CommentaireGeneral $commentaireGeneral): self
    {
        if (!$this->commentaireGenerals->contains($commentaireGeneral)) {
            $this->commentaireGenerals[] = $commentaireGeneral;
            $commentaireGeneral->setUser($this);
        }

        return $this;
    }

    public function removeCommentaireGeneral(CommentaireGeneral $commentaireGeneral): self
    {
        if ($this->commentaireGenerals->contains($commentaireGeneral)) {
            $this->commentaireGenerals->removeElement($commentaireGeneral);
            // set the owning side to null (unless already changed)
            if ($commentaireGeneral->getUser() === $this) {
                $commentaireGeneral->setUser(null);
            }
        }

        return $this;
    }
}
