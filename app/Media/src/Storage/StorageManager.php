<?php

namespace Media\Storage;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class StorageManager implements StorageManagerInterface
{
    /**
     * @var Array
     */
    protected $storages = array();
    
    /**
     * {@inheritDoc}
     */
    public function addStorage($name, StorageInterface $storage)
    {
        if ($this->hasStorage($name) === true) {
            throw new \InvalidArgumentException(
                sprintf('Storage with name "%s" already exists.', $name)
            );
        }
        
        $this->storagees[$name] = $storage;
        
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
        if ($this->hasStorage($name) === false) {
            throw new \InvalidArgumentException(
                sprintf('Storage with name "%s" does not exist.', $name)
            );
        }
        
        return $this->storagees[$name];
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