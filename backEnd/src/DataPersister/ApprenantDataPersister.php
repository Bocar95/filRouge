<?php

// src/DataPersister

namespace App\DataPersister;

use App\Entity\Apprenant;
use Doctrine\ORM\EntityManagerInterface;
use App\Datapersister\ApprenantDataPersister;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
 

/**
 *
 */
class ApprenantDataPersister implements DataPersisterInterface,ContextAwareDataPersisterInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $_entityManager;

    public function __construct( EntityManagerInterface $entityManager ) 
    {
        $this->_entityManager = $entityManager;
    }

    
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Apprenant;
    }

    /**
     * @param Apprenant $data
     */
    public function persist($data, array $context = [])
    {
        if (isset($context["collection_operation_name"])) {
            $this->_entityManager->persist($data);
        }
        $this->_entityManager->flush();
    }

    public function remove($data, array $context = [])
    {
        $data->setIsDeleted(true);

        $this->_entityManager->flush();
    }
}