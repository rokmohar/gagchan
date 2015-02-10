<?php

namespace Acl\Factory\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Acl\Mapper\ResourceMapper;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class ResourceMapperFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Database adapter
        $dbAdapter = $serviceLocator->get('db.adapter');
        
        // Entity class
        $entityClass = new \Acl\Entity\ResourceEntity();
        
        // Hydrator
        $hydrator = new \Acl\Hydrator\ResourceHydrator();
        
        return new ResourceMapper($dbAdapter, 'resource', $entityClass, $hydrator);
    }
}