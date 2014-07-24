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
     * Set the identifier.
     * 
     * @param int $id
     */
    public function setId($id);
    
    /**
     * Return the user identifier.
     * 
     * @return int
     */
    public function getUserId();
    
    /**
     * Set the user identifier.
     * 
     * @param int $userId
     */
    public function setUserId($userId);
    
    /**
     * Return the provider.
     * 
     * @return string
     */
    public function getProvider();
    
    /**
     * Set the provider.
     * 
     * @param string $provider
     */
    public function setProvider($provider);
    
    /**
     * Return the provider identifier.
     * 
     * @return string
     */
    public function getProviderId();
    
    /**
     * Return the provider identifier.
     * 
     * @return string $providerId
     */
    public function setProviderId($providerId);
    
    /**
     * Return created at date.
     * 
     * @return \DateTime
     */
    public function getCreatedAt();
    
    /**
     * Set created at date.
     * 
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt);
    
    /**
     * Return updated at date.
     * 
     * @return \DateTime
     */
    public function getUpdatedAt();
    
    /**
     * Set updated at date.
     * 
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt);
}