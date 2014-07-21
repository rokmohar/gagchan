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
     * @return int
     */
    public function getId();
    
    /**
     * Return the media identifier.
     * 
     * @return int
     */
    public function getMediaId();
    
    /**
     * Return the user identifier.
     * 
     * @return int
     */
    public function getUserId();
    
    /**
     * Return the vote type.
     * 
     * @return string
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