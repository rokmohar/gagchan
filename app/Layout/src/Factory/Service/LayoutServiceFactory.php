<?php

namespace Layout\Factory\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Layout\Service\LayoutService;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class LayoutServiceFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Get config
        $config = $serviceLocator->get('Config');
        
        // Get layout options
        $options = $serviceLocator->get('layout.options');
        
        // Get view manager
        $viewManager = $serviceLocator->get('view_manager');
        
        // Create layout service
        return new LayoutService($config, $options, $viewManager);
    }
}