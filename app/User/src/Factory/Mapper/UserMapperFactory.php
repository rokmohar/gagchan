<?php

namespace User\Factory\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use User\Mapper\UserMapper;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class UserMapperFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Database adapter
        $dbAdapter = $serviceLocator->get('db.adapter');
        
        // Entity class
        $entityClass = new \User\Entity\UserEntity();
        
        // Hydrator
        $hydrator = new \User\Hydrator\UserHydrator();
        
        return new UserMapper($dbAdapter, 'user', $entityClass, $hydrator);
    }
}