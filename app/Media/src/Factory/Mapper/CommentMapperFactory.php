<?php

namespace Media\Factory\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Media\Mapper\CommentMapper;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class CommentMapperFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Database adapter
        $dbAdapter = $serviceLocator->get('db.adapter');
        
        // Entity class
        $entityClass = new \Media\Entity\CommentEntity();
        
        // Hydrator
        $hydrator = new \Media\Hydrator\CommentHydrator();
        
        return new CommentMapper($dbAdapter, 'media_comment', $entityClass, $hydrator);
    }
}