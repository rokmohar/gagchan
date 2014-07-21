<?php

namespace Category\Entity;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface CategoryEntityInterface
{
    /**
     * Return the identifier.
     * 
     * @return int
     */
    public function getId();
    
    /**
     * Return the unique slug.
     * 
     * @return string
     */
    public function getSlug();
    
    /**
     * Return the resource name.
     * 
     * @return string
     */
    public function getName();
    
    /**
     * Return the priority.
     * 
     * @return int
     */
    public function getPriority();
    
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
