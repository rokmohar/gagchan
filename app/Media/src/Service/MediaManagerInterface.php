<?php

namespace Media\Service;

use Core\File\UploadedImage;
use Category\Entity\CategoryEntityInterface;
use User\Entity\UserEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface MediaManagerInterface
{
    /**
     * Upload file to the storage.
     * 
     * @param \Core\File\UploadedImage                 $file
     * @param string                                   $name
     * @param \User\Entity\UserEntityInterface         $user
     * @param \Category\Entity\CategoryEntityInterface $category
     */
    public function uploadImage(
        UploadedImage $file,
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
