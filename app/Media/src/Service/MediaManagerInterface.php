<?php

namespace Media\Service;

use Core\File\UploadedFile;
use Category\Entity\CategoryEntityInterface;
use ZfcUser\Entity\UserInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface MediaManagerInterface
{
    /**
     * Upload file to the storage.
     * 
     * @param \Core\File\UploadedFile                  $file
     * @param String                                   $name
     * @param \ZfcUser\Entity\UserInterface            $user
     * @param \Category\Entity\CategoryEntityInterface $category
     */
    public function uploadImage(
        UploadedFile $file,
        $name,
        UserInterface $user,
        CategoryEntityInterface $category
    );
    
    /**
     * Get media mapper.
     * 
     * @return \Media\Mapper\MediaMapperInterface
     */
    public function getMediaMapper();
    
    /**
     * Get storage manager.
     * 
     * @return \Media\Storage\StorageMapperInterface
     */
    public function getStorageManager();
}
