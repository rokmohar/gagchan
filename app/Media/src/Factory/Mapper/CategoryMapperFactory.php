<?php

namespace Media\Factory\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Media\Mapper\CategoryMapper;

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
        
        // Return mapper
        return new CategoryMapper($dbAdapter, 'category');
    }
}