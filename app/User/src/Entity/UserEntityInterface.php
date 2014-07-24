<?php

namespace User\Entity;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface UserEntityInterface
{
    /**#@+*/
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
     * Set the identifier.
     * 
     * @param int $id
     */
    public function setId($id);
    
    /**
     * Return the username.
     * 
     * @return string
     */
    public function getUsername();
    
    /**
     * Set the username.
     * 
     * @param string $username
     */
    public function setUsername($username);
    
    /**
     * Return the email address.
     * 
     * @return string
     */
    public function getEmail();
    
    /**
     * Set the email address.
     * 
     * @param string $email
     */
    public function setEmail($email);
    
    /**
     * Return the encrypted password.
     * 
     * @return string
     */
    public function getPassword();
    
    /**
     * Set the encrypted password.
     * 
     * @param string $password
     */
    public function setPassword($password);
    
    /**
     * Return the state.
     * 
     * @return int
     */
    public function getState();
    
    /**
     * Set the state.
     * 
     * @param int $state
     */
    public function setState($state);
    
    /**
     * Return created at date.
     * 
     * @return \DateTime
     */
    public function getCreatedAt();
    
    /**
     * Set created at date.
     * 
     * @param \DateTime
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