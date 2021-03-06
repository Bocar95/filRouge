<?php

// src/DataPersister

namespace App\DataPersister;

use App\Entity\Competence;
use Doctrine\ORM\EntityManagerInterface;
use App\Datapersister\CompetenceDataPersister;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
 

/**
 *
 */
class CompetenceDataPersister implements DataPersisterInterface,ContextAwareDataPersisterInterface
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
        return $data instanceof Competence;
    }

    /**
     * @param Competence $data
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