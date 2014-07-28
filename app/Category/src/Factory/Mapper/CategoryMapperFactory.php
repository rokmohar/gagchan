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
        // Module options
        $options = $serviceLocator->get('category.options.module');
        // Database adapter
        $dbAdapter = $serviceLocator->get('db.adapter');
        // Entity
        $entityClass = $options->getCategoryEntity();
        $entity      = new $entityClass();
        // Hydrator
        $hydratorClass = $options->getCategoryHydrator();
        $hydrator      = new $hydratorClass();
        // Return mapper
        return new CategoryMapper($dbAdapter, 'category', $entity, $hydrator);
    }
}