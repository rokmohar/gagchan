<?php

namespace OAuth\Entity;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface OAuthEntityInterface
{
    /**
     * Return the identifier.
     * 
     * @return int
     */
    public function getId();
    
    /**
     * Return the user identifier.
     * 
     * @return int
     */
    public function getUserId();
    
    /**
     * Return the provider.
     * 
     * @return string
     */
    public function getProvider();
    
    /**
     * Return the provider identifier.
     * 
     * @return string
     */
    public function getProviderId();
    
    /**
     * Return created at date.
     * 
     * @return \DateTime
     */
    public function getCreatedAt();
    
    /**
     * Return updated at date.
     * 
     * @return \DateTime
     */
    public function getUpdatedAt();
}