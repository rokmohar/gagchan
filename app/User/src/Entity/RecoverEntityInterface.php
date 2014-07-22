<?php

namespace User\Entity;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface RecoverEntityInterface
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
     * Return the email address.
     * 
     * @return string
     */
    public function getEmail();
    
    /**
     * Return the remote address.
     * 
     * @return string
     */
    public function getRemoteAddress();
    
    /**
     * Return the requested at date.
     * 
     * @return \DateTime
     */
    public function getRequestAt();
    
    /**
     * Return the request token.
     * 
     * @return string
     */
    public function getRequestToken();
    
    /**
     * Return the requested at date.
     * 
     * @return \DateTime
     */
    public function getRecoveredAt();
    
    /**
     * Check whether is recovered.
     * 
     * @return bool
     */
    public function isRecovered();
    
    /**
     * Return the created at date.
     * 
     * @return \DateTime
     */
    public function getCreatedAt();
    
    /**
     * Return the updated at date.
     * 
     * @return \DateTime
     */
    public function getUpdatedAt();
}
