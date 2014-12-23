<?php

namespace Layout\Factory\Options;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Layout\Options\LayoutOptions;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class LayoutOptionsFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Config
        $config = $serviceLocator->get('Config');
        
        // Get layout config
        $layoutConfig = isset($config['layout_scheme']) ?
            $config['layout_scheme'] : array();
        
        // Create layout options
        return new LayoutOptions($layoutConfig);
    }
}