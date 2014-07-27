<?php

namespace OAuth\Manager;

use OAuth\Manager\Exception\InvalidArgumentException;
use OAuth\Manager\Exception\InvalidProviderException;
use OAuth\Manager\Exception\MissingParameterException;
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
    public function connect(array $params)
    {
        // Check if user is not given
        if (!array_key_exists('user', $params)) {
            // Throw an exception
            throw new MissingParameterException("Parameters must contain a user.");
        }
        
        // Get user
        $user = $params['user'];
        
        // Check if user does not have correct class
        if (!$user instanceof UserEntityInterface) {
            // Throw an exception
            throw new InvalidArgumentException(sprintf(
                "User must be an instance of \User\Entity\UserEntityInterface, \"%s\" given.",
                is_object($user) ? get_class($user) : gettype($user)
            ));
        }
        
        // Check if provider is not given
        if (!array_key_exists('provider', $params)) {
            // Throw an exception
            throw new MissingParameterException("Parameters must contain a provider.");
        }
        
        // Get provider
        $provider = $params['provider'];
        
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
    public function disconnect(array $params)
    {
        // Check if user is not given
        if (!array_key_exists('user', $params)) {
            // Throw an exception
            throw new MissingParameterException("Parameters must contain a user.");
        }
        
        // Get user
        $user = $params['user'];
        
        // Check if user does not have correct class
        if (!$user instanceof UserEntityInterface) {
            // Throw an exception
            throw new InvalidArgumentException(sprintf(
                "User must be an instance of \User\Entity\UserEntityInterface, \"%s\" given.",
                is_object($user) ? get_class($user) : gettype($user)
            ));
        }
        
        // Check if provider is not given
        if (!array_key_exists('provider', $params)) {
            // Throw an exception
            throw new MissingParameterException("Parameters must contain a provider.");
        }
        
        // Get provider
        $provider = $params['provider'];
        
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
