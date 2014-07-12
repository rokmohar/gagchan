<?php

namespace Media\Entity;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface CategoryEntityInterface
{
    /**
     * Return the identifier.
     * 
     * @return Integer
     */
    public function getId();
    
    /**
     * Return the unique slug.
     * 
     * @return String
     */
    public function getSlug();
    
    /**
     * Return the resource name.
     * 
     * @return String
     */
    public function getName();
    
    /**
     * Return created at datetime.
     * 
     * @return \DateTime
     */
    public function getCreatedAt();
    
    /**
     * Return updated at datetime.
     * 
     * @return \DateTime
     */
    public function getUpdatedAt();
}
