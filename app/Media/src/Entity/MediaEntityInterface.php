<?php

namespace Media\Entity;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface MediaEntityInterface
{
    /**
     * {@inheritDoc}
     */
    public function getId();
    
    /**
     * {@inheritDoc}
     */
    public function getSlug();
    
    /**
     * {@inheritDoc}
     */
    public function getName();
    
    /**
     * {@inheritDoc}
     */
    public function getReference();
    
    /**
     * {@inheritDoc}
     */
    public function getThumbnail();
    
    /**
     * {@inheritDoc}
     */
    public function getUserId();
    
    /**
     * {@inheritDoc}
     */
    public function getCategoryId();
    
    /**
     * {@inheritDoc}
     */
    public function getWidth();
    
    /**
     * {@inheritDoc}
     */
    public function getHeight();
    
    /**
     * {@inheritDoc}
     */
    public function getSize();
    
    /**
     * {@inheritDoc}
     */
    public function getContentType();
    
    /**
     * {@inheritDoc}
     */
    public function isFeatured();
            
    /**
     * @return \DateTime
     */
    public function getCreatedAt();
    
    /**
     * @return \DateTime
     */
    public function getUpdatedAt();
}