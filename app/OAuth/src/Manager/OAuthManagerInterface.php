<?php

namespace OAuth\Manager;

use OAuth\Mapper\OAuthMapperInterface;
use User\Entity\UserEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface OAuthManagerInterface
{
    /**
     * Connect the user to OAuth provider.
     * 
     * @param \User\Entity\UserEntityInterface $user
     * @param string                           $provider
     */
    public function connect(UserEntityInterface $user, $provider);
    
    /**
     * Disconnect the user from OAuth provider.
     * 
     * @param \User\Entity\UserEntityInterface $user
     * @param string                           $provider
     */
    public function disconnect(UserEntityInterface $user, $provider);
    
    /**
     * Return the hybrid auth.
     * 
     * @return \Hybrid_Auth
     */
    public function getHybridAuth();
    
    /**
     * Set the hybdrid auth.
     * 
     * @param \Hybrid_Auth $hybridAuth
     */
    public function setHybridAuth(\Hybrid_Auth $hybridAuth);
    
    /**
     * Return the OAuth mapper.
     * 
     * @return \OAuth\Mapper\OAuthMapperInterface
     */
    public function getOAuthMapper();
    
    /**
     * Set the OAuth mapper.
     * 
     * @param \OAuth\Mapper\OAuthMapperInterface $oauthMapper
     */
    public function setOAuthMapper(OAuthMapperInterface $oauthMapper);
}
