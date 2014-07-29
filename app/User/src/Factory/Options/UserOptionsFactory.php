<?php

namespace User\Factory\Options;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use User\Options\UserOptions;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class UserOptionsFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Config
        $config = $serviceLocator->get('Config');
        
        // Module config
        $moduleConfig = isset($config['user']) ? $config['user'] : array();
        
        // Return mapper
        return new UserOptions($moduleConfig);
    }
}