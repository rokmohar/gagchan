<?php

namespace Media\Entity;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
interface ResponseEntityInterface
{
    /**
     * Return the identifier.
     * 
     * @return Integer
     */
    public function getId();
    
    /**
     * Return the media identifier.
     * 
     * @return Integer
     */
    public function getMediaId();
    
    /**
     * Return the user identifier.
     * 
     * @return Integer
     */
    public function getUserId();
    
    /**
     * Return the response type.
     * 
     * @return String
     */
    public function getType();
    
    /**
     * Return created at datetime.
     * 
     * @return \DateTime
     */
    public function getCreatedAt();
    
    /**
     * Return updated at datetime.
     * 
     * @return \DateTime
     */
    public function getUpdatedAt();
    
}