<?php

namespace Acl\Factory\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Acl\Mapper\RoleMapper;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class RoleMapperFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Database adapter
        $dbAdapter = $serviceLocator->get('db.adapter');
        
        // Entity class
        $entityClass = new \Acl\Entity\RoleEntity();
        
        // Hydrator
        $hydrator = new \Acl\Hydrator\RoleHydrator();
        
        return new RoleMapper($dbAdapter, 'role', $entityClass, $hydrator);
    }
}