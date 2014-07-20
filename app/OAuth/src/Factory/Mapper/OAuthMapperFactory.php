<?php

namespace OAuth\Factory\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use OAuth\Mapper\OAuthMapper;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class OAuthMapperFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Database adapter
        $dbAdapter = $serviceLocator->get('db.adapter');
        
        // Entity class
        $entityClass = new \OAuth\Entity\OAuthEntity();
        
        // Hydrator
        $hydrator = new \OAuth\Hydrator\OAuthHydrator();
        
        return new OAuthMapper($dbAdapter, 'user_oauth', $entityClass, $hydrator);
    }
}