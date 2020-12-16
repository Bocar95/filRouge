<?php

namespace App\Entity;

use App\Entity\User;
use App\Repository\CmRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=CmRepository::class)
 * @ApiResource(
 *      collectionOperations={
 *         "get"={"path"="/cm",
 *                  "access_control"="(is_granted('ROLE_ADMIN'))",
 *                  "access_control_message"="Vous n'avez pas access à cette Ressource",
 *                  "normalization_context"={"groups"={"get_cm:read"}}
 *          },
 *         "post"={"path"="/cm",
 *                 "route_name"="add_cm"
 *          }
 *      },
 *      itemOperations={
 *          "get"={"path"="/cm/{id}",
 *                "requirements"={"id"="\d+"},
 *                "access_control"="(is_granted('ROLE_ADMIN'))",
 *                "access_control_message"="Vous n'avez pas access à cette Ressource",
 *                "normalization_context"={"groups"={"get_cm_by_id:read"}}
 *          },
 *          "put"={"path"="/cm/{id}",
 *                "requirements"={"id"="\d+"},
 *                "access_control"="(is_granted('ROLE_ADMIN'))",
 *                "access_control_message"="Vous n'avez pas access à cette Ressource"
 *          },
 *          "delete"={"path"="/cm/{id}",
 *                "requirements"={"id"="\d+"},
 *                "access_control"="(is_granted('ROLE_ADMIN'))",
 *                "access_control_message"="Vous n'avez pas access à cette Ressource"
 *          }
 *      }
 * )
 */
class Cm extends User
{

    public function getId(): ?int
    {
        return $this->id;
    }
}
