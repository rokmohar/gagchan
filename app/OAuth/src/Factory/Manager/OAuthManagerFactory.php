<?php

namespace OAuth\Factory\Manager;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use OAuth\Manager\OAuthManager;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class OAuthManagerFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Create manager
        $oauthManager = new OAuthManager();
        
        // Set hybrid auth
        $oauthManager->setHybridAuth($serviceLocator->get('oauth.hybridauth'));
        
        // Set OAuth mapper
        $oauthManager->setOAuthMapper($serviceLocator->get('oauth.mapper.oauth'));
        
        // Return manager
        return $oauthManager;
    }
}