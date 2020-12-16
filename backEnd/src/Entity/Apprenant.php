<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ApprenantRepository;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=ApprenantRepository::class)
 * @ApiResource(
 *      collectionOperations={
 *         "get"={"path"="/apprenants",
 *                  "access_control"="(is_granted('ROLE_ADMIN','ROLE_FORMATEUR','ROLE_CM'))",
 *                  "access_control_message"="Vous n'avez pas access à cette Ressource",
 *                  "normalization_context"={"groups"={"get_apprenants:read"}}
 *          },
 *         "post"={"path"="/apprenant",
 *                 "route_name"="add_apprenant"
 *          }
 *      },
 *      itemOperations={
 *          "get"={"path"="/apprenant/{id}",
 *                "requirements"={"id"="\d+"},
 *                "access_control"="(is_granted('ROLE_ADMIN','ROLE_FORMATEUR','ROLE_CM'))",
 *                "access_control_message"="Vous n'avez pas access à cette Ressource",
 *                "normalization_context"={"groups"={"get_apprenant_by_id:read"}}
 *          },
 *          "put"={"path"="/apprenant/{id}",
 *                "requirements"={"id"="\d+"},
 *                "access_control"="(is_granted('ROLE_ADMIN','ROLE_FORMATEUR'))",
 *                "access_control_message"="Vous n'avez pas access à cette Ressource"
 *          },
 *          "delete"={"path"="/apprenant/{id}",
 *                "requirements"={"id"="\d+"},
 *                "access_control"="(is_granted('ROLE_ADMIN','ROLE_FORMATEUR'))",
 *                "access_control_message"="Vous n'avez pas access à cette Ressource"
 *          }
 *      }
 * )
 */
class Apprenant extends User
{

    public function getId(): ?int
    {
        return $this->id;
    }
}
