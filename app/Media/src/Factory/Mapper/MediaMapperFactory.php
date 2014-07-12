<?php

namespace Media\Factory\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
//use Zend\Stdlib\Hydrator\ClassMethods;

use Media\Mapper\MediaMapper;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class MediaMapperFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Database adapter
        $dbAdapter = $serviceLocator->get('db.adapter');
        
        // Entity class
        $entityClass = new \Media\Entity\MediaEntity();
        
        // Hydrator
        $hydrator = new \Media\Hydrator\MediaHydrator();
        
        return new MediaMapper($dbAdapter, 'media', $entityClass, $hydrator);
    }
}