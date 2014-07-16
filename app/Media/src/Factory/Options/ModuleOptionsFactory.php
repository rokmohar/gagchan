<?php

namespace Media\Factory\Options;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Media\Options\ModuleOptions;

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
        
        // Return mapper
        return new ModuleOptions($config);
    }
}