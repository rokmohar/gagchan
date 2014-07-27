<?php

namespace OAuth\Manager;

use OAuth\Manager\Exception\InvalidProviderException;
use OAuth\Entity\OAuthEntity;
use OAuth\Mapper\OAuthMapperInterface;
use User\Entity\UserEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class OAuthManager implements OAuthManagerInterface
{
    /**
     * @var \Hybrid_Auth
     */
    protected $hybridAuth;
    
    /**
     * @var \OAuth\Mapper\OAuthMapperInterface
     */
    protected $oauthMapper;
    
    /**
     * {@inheritDoc}
     */
    public function connect(UserEntityInterface $user, $provider)
    {
        // Get hybrid auth
        $hybridAuth = $this->getHybridAuth();
        
        // Check if provider is not enabled
        if (!array_key_exists($provider, $hybridAuth->getProviders())) {
            // Throw an exception
            throw new InvalidProviderException(
                sprintf("Provider \"%s\" is not enabled or does not exist.", $provider)
            );
        }
        
        // Get OAuth mapper
        $oauthMapper = $this->getOAuthMapper();
        
        // Select a row
        $row = $oauthMapper->selectRowByProvider($user->getId(), $provider);
        
        // Check if row exists
        if (!empty($row)) {
            // Return row
            return $row;
        }
        
        // Authenticate provider
        $adapter = $hybridAuth->authenticate($provider);
        
        // Get profile
        $profile = $adapter->getUserProfile();
        
        // Create oauth
        $oauth = new OAuthEntity();
        
        $oauth->setUserId($user->getId());
        $oauth->setProvider($provider);
        $oauth->setProviderId($profile->identifier);
        
        // Insert a row
        $oauthMapper->insertRow($oauth);
        
        // Return OAuth
        return $oauth;
    }
    
    /**
     * {@inheritDoc}
     */
    public function disconnect(UserEntityInterface $user, $provider)
    {
        // Get hybrid auth
        $hybridAuth = $this->getHybridAuth();
        
        // Check if provider is not enabled
        if (!array_key_exists($provider, $hybridAuth->getProviders())) {
            // Throw an exception
            throw new InvalidProviderException(
                sprintf("Provider \"%s\" is not enabled or does not exist.", $provider)
            );
        }
        
        // Get OAuth mapper
        $oauthMapper = $this->getOAuthMapper();
        
        // Select a row
        $row = $oauthMapper->selectRowByProvider($user->getId(), $provider);

        // Check if rows exists
        if (!empty($row)) {
            // Delete the row
            $oauthMapper->deleteRow($row);
        }
        
        // Check if provider is connected
        if ($hybridAuth->isConnectedWith($provider)) {
            // Logout provider
            $hybridAuth->getAdapter($provider)->logout();
        }
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getHybridAuth()
    {
        return $this->hybridAuth;
    }
    
    /**
     * {@inheritDoc}
     */
    public function setHybridAuth(\Hybrid_Auth $hybridAuth)
    {
        $this->hybridAuth = $hybridAuth;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOAuthMapper()
    {
        return $this->oauthMapper;
    }
    
    /**
     * {@inheritDoc}
     */
    public function setOAuthMapper(OAuthMapperInterface $oauthMapper)
    {
        $this->oauthMapper = $oauthMapper;
        
        return $this;
    }
}
