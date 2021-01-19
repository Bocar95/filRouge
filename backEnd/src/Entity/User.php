<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"user" = "User", "admin"="Admin", "formateur" = "Formateur", "apprenant" = "Apprenant", "cm"="Cm"})
 * @UniqueEntity("email",message="Cette adresse email est déja utilisé.")
 * @ApiResource(
 *      collectionOperations={
 *         "get"={"path"="/admin/users",
 *                  "access_control"="(is_granted('ROLE_ADMIN'))",
 *                  "access_control_message"="Vous n'avez pas access à cette Ressource",
 *                  "normalization_context"={"groups"={"user:read"}}
 *               }
 *     },
 *     itemOperations={
 *         "get"={"path"="/admin/users/{id}",
 *                "requirements"={"id"="\d+"},
 *                  "access_control"="(is_granted('ROLE_ADMIN'))",
 *                  "access_control_message"="Vous n'avez pas access à cette Ressource",
 *                  "normalization_context"={"groups"={"user:read"}}
 *          },
 *         "delete"={"path"="/admin/users/{id}",
 *                "requirements"={"id"="\d+"},
 *                  "access_control"="(is_granted('ROLE_ADMIN'))",
 *                  "access_control_message"="Vous n'avez pas access à cette Ressource"
 *          }
 *     }
 * )
 * @ApiFilter(BooleanFilter::class, properties={"isDeleted"})
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"users_profil:read","user:read","admin:read","get_admin_by_id:read","get_admins:read","get_apprenants:read","get_apprenant_by_id:read","get_formateurs:read","get_formateur_by_id:read","get_cm:read","get_cm_by_id:read"})
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(
     *     message = "Ce Champ ne doit pas être vide."
     * )
     * @Groups({"users_profil:read","user:read","admin:read","get_admin_by_id:read","get_admins:read","get_apprenants:read","get_apprenant_by_id:read","get_formateurs:read","get_formateur_by_id:read","get_cm:read","get_cm_by_id:read"})
     */
    protected $email;

    protected $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    protected $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *     message = "Ce Champ ne doit pas être vide."
     * )
     * @Groups({"users_profil:read","user:read","admin:read","get_admin_by_id:read","get_admins:read","get_apprenants:read","get_apprenant_by_id:read","get_formateurs:read","get_formateur_by_id:read","get_cm:read","get_cm_by_id:read"})
     */
    protected $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *     message = "Ce Champ ne doit pas être vide."
     * )
     * @Groups({"users_profil:read","user:read","admin:read","get_admin_by_id:read","get_admins:read","get_apprenants:read","get_apprenant_by_id:read","get_formateurs:read","get_formateur_by_id:read","get_cm:read","get_cm_by_id:read"})
     */
    protected $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *     message = "Ce Champ ne doit pas être vide."
     * )
     * @Groups({"users_profil:read","user:read","admin:read","get_admin_by_id:read","get_admins:read","get_apprenants:read","get_apprenant_by_id:read","get_formateurs:read","get_formateur_by_id:read","get_cm:read","get_cm_by_id:read"})
     */
    protected $adresse;

    /**
     * @ORM\Column(type="blob", nullable=true)
     * @Groups({"users_profil:read","user:read","admin:read","get_admin_by_id:read","get_admins:read","get_apprenants:read","get_apprenant_by_id:read","get_formateurs:read","get_formateur_by_id:read","get_cm:read","get_cm_by_id:read"})
     */
    protected $avatar;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isDeleted = false;

    /**
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"user:read","get_admins:read","get_admin_by_id:read","get_admins:read","get_apprenants:read","get_apprenant_by_id:read","get_formateurs:read","get_formateur_by_id:read","get_cm:read","get_cm_by_id:read"})
     */
    protected $profil;

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
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

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar($avatar): self
    {
        $this->avatar = $avatar;

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

    public function getProfil(): ?profil
    {
        return $this->profil;
    }

    public function setProfil(?profil $profil): self
    {
        $this->profil = $profil;

        return $this;
    }
}
