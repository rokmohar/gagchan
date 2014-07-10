<?php

namespace Media\Storage;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
interface StorageInterface
{
    /**
     * Retrieve a file from the storage..
     * 
     * @param String $key
     */
    public function getFile($key);
    
    /**
     * Save file to the storage.
     * 
     * @param String $key
     * @param String $filename
     */
    public function putFile($key, $filename);
    
    /**
     * Return the storage name.
     * 
     * @return String
     */
    public function getName();
}
