<?php

namespace Generator\Entity;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com> 
 */
class PrototypeEntity implements PrototypeEntityInterface
{
    /**
     * @var int
     */
    protected $id;
    
    /**
     * @var string
     */
    protected $slug;
    
    /**
     * @var string
     */
    protected $name;
    
    /**
     * @var string
     */
    protected $reference;
    
    /**
     * @var int
     */
    protected $width;
    
    /**
     * @var int
     */
    protected $height;
    
    /**
     * @var int
     */
    protected $size;
    
    /**
     * @var string
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
     * Constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }
    
    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @param int $id
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
     * @param string $slug
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
     * @return string
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
     * @param string $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
        
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
     * @param int $width
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
     * @param int $height
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
     * @param int $size
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
     * @param string $contentType
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
    
    /**
     * Pre-insert initialization.
     * 
     * @return \Generator\Entity\MediaPrototypeEntity
     */
    public function preInsert()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
    }
    
    /**
     * Pre-update initialization.
     * 
     * @return \Generator\Entity\MediaPrototypeEntity
     */
    public function preUpdate()
    {
        $this->setUpdatedAt(new \DateTime());
    }
}