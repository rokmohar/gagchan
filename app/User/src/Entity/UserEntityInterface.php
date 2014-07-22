<?php

namespace User\Entity;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface UserEntityInterface
{
    /**#@+*/
    const STATE_UNKNOWN     = 0;
    const STATE_CONFIRMED   = 1;
    const STATE_UNCONFIRMED = 2;
    const STATE_DISABLED    = 3;
    /**#@-*/
    
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
     * Check the state.
     * 
     * @return int
     */
    public function getState();
    
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