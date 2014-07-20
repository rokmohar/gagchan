<?php

namespace OAuth\Factory\Options;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use OAuth\Options\ModuleOptions;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class ModuleOptionsFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Config
        $config = $serviceLocator->get('Config');
        
        // Module config
        $moduleConfig = isset($config['oauth']) ? $config['oauth'] : array();
        
        // Return mapper
        return new ModuleOptions($moduleConfig);
    }
}