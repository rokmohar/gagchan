<?php

namespace Generator\Factory\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Generator\View\Helper\PrototypeHelper;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class PrototypeHelperFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $pluginManager)
    {
        // Service locator
        $serviceLocator = $pluginManager->getServiceLocator();

        // Get prototype mapper
        $prototypeMapper = $serviceLocator->get('generator.mapper.prototype');
        
        // Get media options
        $mediaOptions = $serviceLocator->get('media.options.module');

        // Create user helper
        return new PrototypeHelper($prototypeMapper, $mediaOptions);
    }
}
