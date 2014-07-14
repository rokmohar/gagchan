<?php

namespace Media\Factory\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Media\Mapper\VoteMapper;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class VoteMapperFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Database adapter
        $dbAdapter = $serviceLocator->get('db.adapter');
        
        // Entity class
        $entityClass = new \Media\Entity\VoteEntity();
        
        // Hydrator
        $hydrator = new \Media\Hydrator\VoteHydrator();
        
        return new VoteMapper($dbAdapter, 'media_vote', $entityClass, $hydrator);
    }
}