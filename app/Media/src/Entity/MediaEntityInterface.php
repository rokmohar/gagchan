<?php

namespace Media\Entity;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface MediaEntityInterface
{
    /**#@+*/
    const STATE_CONFIRMED   = 1;
    const STATE_UNCONFIRMED = 2;
    const STATE_DISABLED    = 3;
    /**#@-*/
    
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
     * Return the thumbnail.
     * 
     * @return string
     */
    public function getThumbnail();
    
    /**
     * Set the thumbnail.
     * 
     * @param string $thumbnail
     */
    public function setThumbnail($thumbnail);
    
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
     * Return the category identifier.
     * 
     * @return int
     */
    public function getCategoryId();
    
    /**
     * Set the category identifier.
     * 
     * @param int $categoryId
     */
    public function setCategoryId($categoryId);
    
    /**
     * Return the height.
     * 
     * @return int
     */
    public function getHeight();
    
    /**
     * Set the height.
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
     * @param string $contentType
     */
    public function setContentType($contentType);
    
    /**
     * Check whether media is featured.
     * 
     * @return bool
     */
    public function isFeatured();
    
    /**
     * Set whether media is featured.
     * 
     * @param bool $isFeatured
     */
    public function setIsFeatured($isFeatured);
    
    /**
     * Return the state.
     * 
     * @return int
     */
    public function getState();
    
    /**
     * Set the state.
     * 
     * @param int $state
     */
    public function setState($state);
    
    /**
     * Return the delay at date.
     * 
     * @return \DateTime
     */
    public function getDelayAt();
    
    /**
     * Set the delay at date.
     * 
     * @param \DateTime|null $delayAt
     */
    public function setDelayAt(\DateTime $delayAt  = null);
    
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