<?php

namespace Media\Storage;

use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class StorageManager implements StorageManagerInterface
{
    /**
     * @var \Zend\ServiceManager\ServiceLocatorInterface
     */
    protected $serviceLocator;
    
    /**
     * @var array
     */
    protected $storages = array();
    
    /**
     * @var \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     */
    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }
    
    /**
     * {@inheritDoc}
     */
    public function addStorage(StorageInterface $storage)
    {
        if ($this->hasStorage($storage->getName())) {
            throw new \InvalidArgumentException(
                sprintf('Storage with name "%s" already exists.', $storage->getName())
            );
        }
        
        $this->storages[$storage->getName()] = $storage;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function hasStorage($name)
    {
        return isset($this->storages[$name]);
    }
    
    /**
     * {@inheritDoc}
     */
    public function getStorage($name)
    {
        if (!$this->hasStorage($name)) {
            throw new \InvalidArgumentException(
                sprintf('Storage with name "%s" does not exist.', $name)
            );
        }
        
        return $this->storages[$name];
    }
    
    /**
     * {@inheritDoc}
     */
    public function getStorages()
    {
        return $this->storages;
    }
    
    /**
     * {@inheritDoc}
     */
    public function setStorages(array $storages)
    {
        $this->storages = $storages;
        
        return $this;
    }
}