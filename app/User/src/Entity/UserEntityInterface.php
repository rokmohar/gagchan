<?php

namespace User\Entity;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface UserEntityInterface
{
    /**
     * Return the identifier.
     * 
     * @return int
     */
    public function getId();
    
    /**
     * Return the username.
     * 
     * @return string
     */
    public function getUsername();
    
    /**
     * Return the email address.
     * 
     * @return string
     */
    public function getEmail();
    
    /**
     * Return the encrypted password.
     * 
     * @return string
     */
    public function getPassword();
    
    /**
     * Return the confirmation at date.
     * 
     * @return \DateTime
     */
    //public function getConfirmationAt();
    
    /**
     * Return the confirmation token.
     * 
     * @return string
     */
    //public function getConfirmationToken();
    
    /**
     * Return the recover at date.
     * 
     * @return \DateTime
     */
    //public function getRecoverAt();
    
    /**
     * Return the recover token.
     * 
     * @return string
     */
    //public function getRecoverToken();
    
    /**
     * Check if user is enabled.
     * 
     * @return bool
     */
    public function isEnabled();
    
    /**
     * Check if user is confirmed.
     * 
     * @return bool
     */
    public function isConfirmed();
    
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