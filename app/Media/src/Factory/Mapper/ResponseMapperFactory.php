<?php

namespace Media\Factory\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Media\Mapper\ResponseMapper;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class ResponseMapperFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Database adapter
        $dbAdapter = $serviceLocator->get('db.adapter');
        
        // Entity class
        $entityClass = new \Media\Entity\ResponseEntity();
        
        // Hydrator
        $hydrator = new \Media\Hydrator\ResponseHydrator();
        
        return new ResponseMapper($dbAdapter, 'media_response', $entityClass, $hydrator);
    }
}