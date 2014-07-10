<?php

namespace Media\Storage;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
interface MediaStorageInterface
{
    /**
     * Add new storage to the collection.
     * 
     * @param String                           $name
     * @param \Media\Storage\StorageInterface $storage
     */
    public function addStorage($name, StorageInterface $storage);
    
    /**
     * Check if collection contains a storage.
     * 
     * @param String $name
     */
    public function hasStorage($name);
    
    /**
     * Return storage by name.
     * 
     * @param String $name
     */
    public function getStorage($name);
    
    /**
     * Return collection of storages.
     * 
     * @return Array
     */
    public function getStorages();
    
    /**
     * Set collection of storages.
     * 
     * @return Array
     */
    public function setStorages(array $storages);
}
