<?php

namespace Media\Service;

use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Image\ImagineInterface;;

use Core\File\UploadedFile;
use Media\Mapper\MediaMapperInterface;
use Media\Storage\StorageManagerInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class MediaManager implements MediaManagerInterface
{
    /**
     * @var \Imagine\Gd\Imagine
     */
    protected $imagine;
    
    /**
     * @var \Media\Mapper\MediaMapperInterface
     */
    protected $mediaMapper;
    
    /**
     * @var \Media\Storage\StorageManagerInterface
     */
    protected $storageManager;
    
    /**
     * @var \Media\Mapper\MediaMapperInterface     $mediaMapper
     * @var \Media\Storage\StorageManagerInterface $storageManager
     */
    public function __construct(
        MediaMapperInterface $mediaMapper,
        StorageManagerInterface $storageManager
    ) {
        $this->mediaMapper    = $mediaMapper;
        $this->storageManager = $storageManager;
    }
    
    /**
     * @param \Core\File\UploadedFile
     */
    public function uploadFile(UploadedFile $file)
    {
        // Resize file
        $this->resizeFile($file);
        
        // Storage
        $storage = $this->getStorageManager()->getStorage('amazon');
        
        // Upload file to the storage
        $storage->putFile($file->getOriginalName(), $file);
    }
    
    /**
     * @param \Core\File\UploadedFile $file
     * 
     * @return \Media\Service\MediaManager
     */
    protected function resizeFile(UploadedFile $file)
    {
        // Get image
        $imagine = $this->getImagine();
        
        // Open image file with imagine
        $image = $imagine->open($file->getPathname());
        
        // Get image sizes
        $size = $image->getSize();
        
        // Calculate new width and height
        $width  = 460;
        $height = $width * $size->getHeight() / $size->getWidth();
        
        // Resize image
        $image
            ->resize(new Box($width, $height))
            //->save($file->getPathname() . '.jpg')
        ;
        
        return $this;
    }
    
    /**
     * Generate a random string.
     * 
     * @param Integer $length
     * 
     * @return String
     */
    protected function generateString($length = 8)
    {
        $chars  = '0123456789abcdefghijklmnopqrstuvwxyz';
        $string = '';
        
        for ($i = 0; $i < $length; $i++) {
            $string .= $chars[mt_rand(0, strlen($chars) - 1)];
        }

        return $string;
    }
    
    /**
     * @return \Imagine\Gd\Imagine
     */
    public function getImagine()
    {
        if (!$this->imagine instanceof ImagineInterface) {
            return $this->imagine = new Imagine();
        }
        
        return $this->imagine;
    }
    
    /**
     * @return \Media\Mapper\MediaMapperInterface
     */
    public function getMediaMapper()
    {
        return $this->mediaMapper;
    }
    
    /**
     * @return \Media\Storage\StorageMapperInterface
     */
    public function getStorageManager()
    {
        return $this->storageManager;
    }
}