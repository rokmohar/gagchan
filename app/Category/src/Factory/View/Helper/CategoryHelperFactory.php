<?php

namespace Category\Factory\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Category\View\Helper\CategoryHelper;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class CategoryHelperFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $pluginManager)
    {
        // Service locator
        $serviceLocator = $pluginManager->getServiceLocator();

        // Category mapper
        $categoryMapper = $serviceLocator->get('category.mapper.category');

        // Create and return helper
        return new CategoryHelper($categoryMapper);
    }
}