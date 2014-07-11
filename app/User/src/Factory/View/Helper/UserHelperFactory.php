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

        // User mapper
        $userMapper = $serviceLocator->get('zfcuser_user_mapper');

        // Create and return helper
        return new UserHelper($userMapper);
    }
}
