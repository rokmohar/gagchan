<?php

namespace Generator\Factory\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Generator\View\Helper\GeneratorHelper;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class GeneratorHelperFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $pluginManager)
    {
        // Service locator
        $serviceLocator = $pluginManager->getServiceLocator();
        
        // Generator mapper
        $generatorMapper = $serviceLocator->get('generator.mapper.prototype');
        
        // Generator options
        $options = $serviceLocator->get('generator.options.module');

        // Return helper
        return new GeneratorHelper(
            $generatorMapper,
            $options
        );
    }
}