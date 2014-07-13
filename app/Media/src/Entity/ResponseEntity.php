<?php

namespace Media\Entity;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class ResponseEntity implements ResponseEntityInterface
{
    /**
     * @var Integer
     */
    protected $id;
    
    /**
     * @var Integer
     */
    protected $mediaId;
    
    /**
     * @var Integer
     */
    protected $userId;
    
    /**
     * @var String
     */
    protected $type;
    
    /**
     * @var \DateTime
     */
    protected $createdAt;
    
    /**
     * @var \DateTime
     */
    protected $updatedAt;
    
    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set the identifier.
     * 
     * @param Integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getMediaId()
    {
        return $this->mediaId;
    }
    
    /**
     * Set the media identifier.
     * 
     * @param Integer $mediaId
     */
    public function setMediaId($mediaId)
    {
        $this->mediaId = $mediaId;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getUserId()
    {
        return $this->userId;
    }
    
    /**
     * Set the user identifier.
     * 
     * @param Integer $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * Set the type.
     * 
     * @param String $type
     */
    public function setType($type)
    {
        $this->type = $type;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
    /**
     * Set created at datetime.
     * 
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    /**
     * Set updated at datetime.
     * 
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        
        return $this;
    }
}