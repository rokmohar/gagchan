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
     * @return Integer
     */
    public function getId();
    
    /**
     * Return the username.
     * 
     * @return String
     */
    public function getUsername();
    
    /**
     * Return the email address.
     * 
     * @return String
     */
    public function getEmail();
    
    /**
     * Return the encrypted password.
     * 
     * @return String
     */
    public function getPassword();
    
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