<?php

namespace Media\Entity;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
interface VoteEntityInterface
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
     * Return the vote type.
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