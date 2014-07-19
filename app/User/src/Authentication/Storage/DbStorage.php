<?php

namespace User\Authentication\Storage;

use Zend\Authentication\Storage\Session;
use Zend\Authentication\Storage\StorageInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class DbStorage implements StorageInterface, ServiceManagerAwareInterface
{
    /**
     * @var \User\Entity\UserEntityInterface
     */
    protected $identity;
    
    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $serviceManager;
    
    /**
     * @var \Zend\Authentication\Storage\StorageInterface
     */
    protected $storage;
    
    /**
     * @var \User\Mapper\UserMapperInterface
     */
    protected $userMapper;
    
    /**
     * {@inheritDoc}
     */
    public function clear()
    {
        // Clear identity
        $this->identity = null;
        
        // Clear storage
        $this->getStorage()->clear();
        
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function isEmpty()
    {
        if ($this->getStorage()->isEmpty()) {
            // Storage is empty
            return true;
        }
        
        if ($this->read() === null) {
            // Storage is empty
            return true;
        }
        
        // Storage is not empty
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function read()
    {
        // Check if identity is resolved
        if (empty($this->identity) === false) {
            // Return identity
            return $this->identity;
        }
        
        // Get $identifier
        $identifier = $this->getStorage()->read();
        
        // Check if identifier is numeric
        if (is_numeric($identifier) === true) {
            // Resolve identity
            $identity = $this->getUserMapper()->selectRowById($identifier);
            
            // Return resolved identity
            return $this->identity = $identity;
        }
        
        // Unable to resolve
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function write($contents)
    {
        // Clear identity
        $this->identity = null;
        
        // Write to storage
        $this->getStorage()->write($contents);
        
        return $this;
    }
    
    /**
     * @return \Zend\ServiceManager\ServiceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * {@inheritDoc}
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        
        return $this;
    }
    
    /**
     * @return \Zend\Authentication\Storage\StorageInterface
     */
    public function getStorage()
    {
        if ($this->storage === null) {
            return $this->storage = new Session(get_class($this));
        }
        
        return $this->storage;
    }
    
    /**
     * @return \User\Mapper\UserMapperInterface
     */
    public function getUserMapper()
    {
        if ($this->userMapper === null) {
            return $this->userMapper = $this->getServiceManager()->get(
                'user.mapper.user'
            );
        }
        
        return $this->userMapper;
    }
}