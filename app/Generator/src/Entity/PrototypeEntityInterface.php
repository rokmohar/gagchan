<?php

namespace Generator\Entity;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface PrototypeEntityInterface
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
     * Return the slug.
     * 
     * @return string
     */
    public function getSlug();
    
    /**
     * Set the slug.
     * 
     * @param string $slug
     */
    public function setSlug($slug);
    
    /**
     * Return the name.
     * 
     * @return string
     */
    public function getName();
    
    /**
     * Set the name.
     * 
     * @param string $name
     */
    public function setName($name);
    
    /**
     * Return the reference.
     * 
     * @return string
     */
    public function getReference();
    
    /**
     * Set the reference.
     * 
     * @param string $reference
     */
    public function setReference($reference);
    
    /**
     * Return the height.
     * 
     * @return int
     */
    public function getHeight();
    
    /**
     * Set the width.
     * 
     * @param int $height
     */
    public function setHeight($height);
    
    /**
     * Return the width.
     * 
     * @return int
     */
    public function getWidth();
    
    /**
     * Set the width.
     * 
     * @param int $width
     */
    public function setWidth($width);
    
    /**
     * Return the size.
     * 
     * @return int
     */
    public function getSize();
    
    /**
     * Set the size.
     * 
     * @param int $size
     */
    public function setSize($size);
    
    /**
     * Return the content type.
     * 
     * @return string
     */
    public function getContentType();
    
    /**
     * Set the content type.
     * 
     * @return string $contentType
     */
    public function setContentType($contentType);
    
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