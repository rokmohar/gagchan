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