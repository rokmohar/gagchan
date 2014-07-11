<?php

namespace Media\Entity;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class MediaEntity implements MediaEntityInterface
{
    /**
     * @var Integer
     */
    protected $id;
    
    /**
     * @var String
     */
    protected $slug;
    
    /**
     * @var String
     */
    protected $name;
    
    /**
     * @var String
     */
    protected $reference;
    
    /**
     * @var Integer
     */
    protected $userId;
    
    /**
     * @var Integer
     */
    protected $categoryId;
    
    /**
     * @var Integer
     */
    protected $width;
    
    /**
     * @var Integer
     */
    protected $height;
    
    /**
     * @var Integer
     */
    protected $size;
    
    /**
     * @var String
     */
    protected $contentType;
    
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
    public function getSlug()
    {
        return $this->slug;
    }
    
    /**
     * @param String $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * @return String
     */
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getReference()
    {
        return $this->reference;
    }
    
    /**
     * @param String $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
        
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
    public function getCategoryId()
    {
        return $this->categoryId;
    }
    
    /**
     * @param Integer $categoryId
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getWidth()
    {
        return $this->width;
    }
    
    /**
     * @param Integer $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getHeight()
    {
        return $this->height;
    }
    
    /**
     * @param Integer $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getSize()
    {
        return $this->size;
    }
    
    /**
     * @param Integer $size
     */
    public function setSize($size)
    {
        $this->size = $size;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getContentType()
    {
        return $this->contentType;
    }
    
    /**
     * @param String $contentType
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
        
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
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt)
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
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
        
        return $this;
    }
}