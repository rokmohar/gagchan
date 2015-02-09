<?php

namespace Acl\Entity;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface PermissionEntityInterface
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
     * @return int
     */
    public function getResourceId();
    
    /**
     * @param int $resourceId
     */
    public function setResourceId($resourceId);
    
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