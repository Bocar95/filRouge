<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CmRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=CmRepository::class)
 */
class Cm extends User
{
    public function getId(): ?int
    {
        return $this->id;
    }
}
