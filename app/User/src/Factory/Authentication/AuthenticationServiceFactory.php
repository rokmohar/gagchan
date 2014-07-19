<?php

namespace User\Factory\Authentication;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use User\Authentication\AuthenticationService;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class AuthenticationServiceFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Authentication storage
        $authStorage = $serviceLocator->get('user.auth.storage.db');
        
        // Create authentication service
        $authService = new AuthenticationService($authStorage);
        
        // @todo: put this to configuration
        $authAdapters = array(
            100 => 'user.auth.adapter.db',
        );
        
        // Attach multiple adapters and events
        foreach ($authAdapters as $priority => $service) {
            // Get adapter
            $adapter = $serviceLocator->get($service);
            
            // Check if adapter has authenticate function
            if (is_callable(array($adapter, 'authenticate'))) {
                // Attach to event manager
                $authService->getEventManager()->attach(
                    'authenticate',
                    array($adapter, 'authenticate'),
                    $priority
                );
            }

            // Check if adapter has logout function
            if (is_callable(array($adapter, 'logout'))) {
                // Attach to event manager
                $authService->getEventManager()->attach(
                    'logout',
                    array($adapter, 'logout'),
                    $priority
                );
            }
        }
        
        // Return authentication service
        return $authService;
    }
}