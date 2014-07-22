<?php

namespace User\Entity;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface ConfirmationEntityInterface
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
     * Return request at date.
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
     * Return confirmed at date.
     * 
     * @return string
     */
    public function getConfirmedAt();
    
    /**
     * Check whether the user is confirmed.
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
