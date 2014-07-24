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
     * Set the identifier.
     * 
     * @param int $id
     */
    public function setId($id);
    
    /**
     * Return the media identifier.
     * 
     * @return int
     */
    public function getMediaId();
    
    /**
     * Set the media identifier.
     * 
     * @param int $mediaId
     */
    public function setMediaId($mediaId);
    
    /**
     * Return the user identifier.
     * 
     * @return int
     */
    public function getUserId();
    
    /**
     * Set the user identifier.
     * 
     * @param int $userId
     */
    public function setUserId($userId);
    
    /**
     * Return the comment text.
     * 
     * @return string
     */
    public function getComment();
    
    /**
     * Set the comment text.
     * 
     * @param string $comment
     */
    public function setComment($comment);
    
    /**
     * Return created at date.
     * 
     * @return \DateTime
     */
    public function getCreatedAt();
    
    /**
     * Set created at date.
     * 
     * @param \DateTime $createdAt
     */
    public function setCreatedat(\DateTime $createdAt);
    
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