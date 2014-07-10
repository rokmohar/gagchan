<?php

namespace Media\Service;

use Core\File\UploadedFile;

interface MediaManagerInterface
{
    /**
     * Upload file to the storage.
     * 
     * @param \Core\File\UploadedFile $file
     * @param String                  $name
     */
    public function uploadFile(UploadedFile $file, $name);
    
    /**
     * @return \Media\Mapper\MediaMapperInterface
     */
    public function getMediaMapper();
}
