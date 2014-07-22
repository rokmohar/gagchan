<?php

namespace User\Factory\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use User\Mapper\ConfirmationMapper;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class ConfirmationMapperFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Database adapter
        $dbAdapter = $serviceLocator->get('db.adapter');
        
        // Entity class
        $entityClass = new \User\Entity\ConfirmationEntity();
        
        // Hydrator
        $hydrator = new \User\Hydrator\ConfirmationHydrator();
        
        // Create mapper
        return new ConfirmationMapper(
            $dbAdapter,
            'user_confirmation',
            $entityClass,
            $hydrator
        );
    }
}