<?php

namespace Acl\Entity;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface ResourceEntityInterface
{
    /**
     * @return int
     */
    public function getId();
    
    /**
     * @param int $id
     */
    public function setId($id);
    
    /**
     * @return string
     */
    public function getName();
    
    /**
     * @param string $name
     */
    public function setName($name);
    
    /**
     * @return \DateTime
     */
    public function getCreatedAt();
    
    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedat(\DateTime $createdAt);
    
    /**
     * @return \DateTime
     */
    public function getUpdatedAt();
    
    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt);
}