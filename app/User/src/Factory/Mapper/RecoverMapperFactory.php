<?php

namespace User\Factory\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use User\Mapper\RecoverMapper;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class RecoverMapperFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Database adapter
        $dbAdapter = $serviceLocator->get('db.adapter');
        
        // Entity class
        $entityClass = new \User\Entity\RecoverEntity();
        
        // Hydrator
        $hydrator = new \User\Hydrator\RecoverHydrator();
        
        // Create mapper
        return new RecoverMapper(
            $dbAdapter,
            'user_recover',
            $entityClass,
            $hydrator
        );
    }
}