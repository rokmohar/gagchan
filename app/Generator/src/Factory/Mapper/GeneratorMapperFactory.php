<?php

namespace Generator\Factory\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Generator\Mapper\GeneratorMapper;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class GeneratorMapperFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Database adapter
        $dbAdapter = $serviceLocator->get('db.adapter');
        
        // Entity class
        $entityClass = new \Generator\Entity\GeneratorEntity();
        
        // Hydrator
        $hydrator = new \Generator\Hydrator\GeneratorHydrator();
        
        return new GeneratorMapper($dbAdapter, 'media_prototype', $entityClass, $hydrator);
    }
}