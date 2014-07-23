<?php

namespace Generator\Entity;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface GeneratorEntityInterface
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