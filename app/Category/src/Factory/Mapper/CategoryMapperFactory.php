<?php

namespace Category\Factory\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Category\Mapper\CategoryMapper;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class CategoryMapperFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Database adapter
        $dbAdapter = $serviceLocator->get('db.adapter');
        
        // Entity class
        $entityClass = new \Category\Entity\CategoryEntity();
        
        // Hydrator
        $hydrator = new \Category\Hydrator\CategoryHydrator();
        
        // Return mapper
        return new CategoryMapper($dbAdapter, 'category', $entityClass, $hydrator);
    }
}