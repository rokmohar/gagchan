<?php

namespace Core\Factory\Options;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Core\Options\ModuleOptions;

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
        $moduleConfig = isset($config['core']) ? $config['core'] : array();
        
        // Return mapper
        return new ModuleOptions($moduleConfig);
    }
}