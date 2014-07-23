<?php

namespace Media\Service;

use Core\File\UploadedFile;
use Media\Entity\MediaEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface MediaManagerInterface
{
    /**
     * Upload an image.
     * 
     * @param \Core\File\UploadedFile            $file
     * @param \Media\Entity\MediaEntityInterface $media
     */
    public function uploadImage(
        UploadedFile $file,
        MediaEntityInterface $media
    );
    
    /**
     * Return the media mapper.
     * 
     * @return \Media\Mapper\MediaMapperInterface
     */
    public function getMediaMapper();
    
    /**
     * Return the storage manager.
     * 
     * @return \Media\Storage\StorageMapperInterface
     */
    public function getStorageManager();
}
