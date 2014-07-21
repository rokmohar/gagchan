<?php

namespace Media\Entity;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface CommentEntityInterface
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
     * Return the comment text.
     * 
     * @return string
     */
    public function getComment();
    
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