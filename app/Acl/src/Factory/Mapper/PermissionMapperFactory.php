<?php

namespace Acl\Factory\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Acl\Mapper\PermissionMapper;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class PermissionMapperFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Database adapter
        $dbAdapter = $serviceLocator->get('db.adapter');
        
        // Entity class
        $entityClass = new \Acl\Entity\PermissionEntity();
        
        // Hydrator
        $hydrator = new \Acl\Hydrator\PermissionHydrator();
        
        return new PermissionMapper($dbAdapter, 'permission', $entityClass, $hydrator);
    }
}