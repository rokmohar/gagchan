<?php

namespace User\Factory\Controller\Plugin;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use User\Controller\Plugin\UserPlugin;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class UserPluginFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $pluginManager)
    {
        // Get service locator
        $serviceLocator = $pluginManager->getServiceLocator();

        // Get authentication service
        $authService = $serviceLocator->get('user.auth.service');

        // Create user plugin
        return new UserPlugin($authService);
    }
}