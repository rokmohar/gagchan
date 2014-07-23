<?php

namespace Media\Storage;

use Core\File\UploadedFile;
use Media\Entity\MediaEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
interface StorageInterface
{
    /**
     * Retrieve a file from the storage..
     * 
     * @param string $key
     */
    public function getFile($key);
    
    /**
     * Save file to the storage.
     * 
     * @param string                             $key
     * @param \Core\File\UploadedFile            $file
     * @param \Media\Entity\MediaEntityInterface $media
     */
    public function putFile($key, UploadedFile $file, MediaEntityInterface $media);
    
    /**
     * Return the storage name.
     * 
     * @return string
     */
    public function getName();
}
