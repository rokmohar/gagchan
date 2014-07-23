<?php

namespace Generator\Factory\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Generator\Mapper\PrototypeMapper;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class PrototypeMapperFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Database adapter
        $dbAdapter = $serviceLocator->get('db.adapter');
        
        // Entity class
        $entityClass = new \Generator\Entity\PrototypeEntity();
        
        // Hydrator
        $hydrator = new \Generator\Hydrator\PrototypeHydrator();
        
        return new PrototypeMapper(
            $dbAdapter,
            'media_prototype',
            $entityClass,
            $hydrator
        );
    }
}