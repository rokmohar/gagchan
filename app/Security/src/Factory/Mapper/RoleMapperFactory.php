<?php

namespace Security\Factory\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Security\Mapper\RoleMapper;

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
        $entityClass = new \Security\Entity\RoleEntity();
        
        // Hydrator
        $hydrator = new \Security\Hydrator\RoleHydrator();
        
        return new RoleMapper($dbAdapter, 'role', $entityClass, $hydrator);
    }
}