<?php

namespace User\Factory\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use User\View\Helper\UserHelper;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class UserHelperFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $pluginManager)
    {
        // Service locator
        $serviceLocator = $pluginManager->getServiceLocator();

        // Authentication service
        $authService = $serviceLocator->get('user.auth.service');
        
        // User mapper
        $userMapper = $serviceLocator->get('user.mapper.user');

        // Create user helper
        return new UserHelper($authService, $userMapper);
    }
}
