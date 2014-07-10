<?php

namespace Media\Service;

use Core\File\UploadedFile;

interface MediaManagerInterface
{
    /**
     * Upload file to the storage.
     * 
     * @param \Core\File\UploadedFile $file
     */
    public function uploadFile(UploadedFile $file);
    
    /**
     * @return \Media\Mapper\MediaMapperInterface
     */
    public function getMediaMapper();
}
