<?php

namespace Media\Entity;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface MediaEntityInterface
{
    /**
     * Return the identifier.
     * 
     * @param int
     */
    public function getId();
    
    /**
     * Return the slug.
     * 
     * @return string
     */
    public function getSlug();
    
    /**
     * Return the name.
     * 
     * @param string
     */
    public function getName();
    
    /**
     * Return the reference.
     * 
     * @return string
     */
    public function getReference();
    
    /**
     * Return the thumbnail.
     * 
     * @return string
     */
    public function getThumbnail();
    
    /**
     * Return the user identifier.
     * 
     * @return int
     */
    public function getUserId();
    
    /**
     * Return the category identifier.
     * 
     * @return int
     */
    public function getCategoryId();
    
    /**
     * Return width in pixels.
     * 
     * @param int
     */
    public function getWidth();
    
    /**
     * Return height in pixels.
     * 
     * @param int
     */
    public function getHeight();
    
    /**
     * Return size in bytes.
     * 
     * @return int
     */
    public function getSize();
    
    /**
     * Return the content type.
     * 
     * @return string
     */
    public function getContentType();
    
    /**
     * Check if media is enabled.
     * 
     * @return bool
     */
    public function isEnabled();
    
    /**
     * Check if media is featured.
     * 
     * @return bool
     */
    public function isFeatured();
    
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