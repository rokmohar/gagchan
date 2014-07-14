<?php

namespace Media\Service;

use Imagine\Gd\Imagine;
use Imagine\Image\Box;
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
     * {@inheritDoc}
     */
    public function uploadFile(UploadedFile $file, $name, $userId, $categoryId)
    {
        // Resize image
        $this->resizeImage($file);
        
        // Get unique slug
        $slug = $this->getUniqueSlug();
        
        // Insert image data into DB
        $this->insertData($file, $slug, $name,  $userId, $categoryId);
        
        // Storage
        $storage = $this->getStorageManager()->getStorage('amazon');
        
        // Upload file to the storage
        $storage->putFile($slug, $file);
        
        return $this;
    }
    
    /**
     * @param \Core\File\UploadedFile $file
     * @param String                  $slug
     * @param String                  $name
     * @param Integer                 $userId
     * @param Integer                 $categoryId
     * 
     * @return \Media\Service\MediaManager
     */
    protected function insertData(UploadedFile $file, $slug, $name, $userId, $categoryId)
    {
        // Media mapper
        $mediaMapper = $this->getMediaMapper();
        
        // Imagine
        $imagine = $this->getImagine();
        
        // Open image
        $image = $imagine->open($file->getPathname());
        $size  = $image->getSize();
        
        // Insert media into DB
        $mediaMapper->insertRow(
            $slug,
            $name,
            sprintf("/photo/%s_460b.%s", $slug, $file->guessExtension()),
            $userId,
            $categoryId,
            $size->getWidth(),
            $size->getHeight(),
            $file->getSize(),
            $file->getMimeType()
        );
        
        return $this;
    }
    
    /**
     * @param \Core\File\UploadedFile $file
     * 
     * @return \Media\Service\MediaManager
     */
    protected function resizeImage(UploadedFile $file)
    {
        // Get image
        $imagine = $this->getImagine();
        
        // Open image file with imagine
        $image = $imagine->open($file->getPathname());
        
        // Get image sizes
        $size = $image->getSize();
        
        // Check if width is alredy 460px
        if ($size->getWidth() === 460) {
            // Skip resizing
            return $this;
        }
        
        // Calculate new width and height
        $width  = 460;
        $height = $width * $size->getHeight() / $size->getWidth();
        
        // Resize image
        $image
            ->resize(new Box($width, $height))
            ->save($file->getPathname(), array(
                'format' => 'jpg',
            ))
        ;
        
        $file
            ->setMimeType('image/jpeg')
            ->setSize(filesize($file->getPathname()))
        ;
        
        return $this;
    }
    
    /**
     * Get a unique slug.
     * 
     * @return String
     */
    protected function getUniqueSlug()
    {
        // Generate a slug
        $slug = $this->getRandomString(8);
        
        // Media mapper
        $mediaMapper = $this->getMediaMapper();
        
        // Check if slug is unique
        if ($mediaMapper->isUniqueSlug($slug) === true) {
            // Return unique slug
            return $slug;
        }
        
        // Generate a new slug
        return $this->getUniqueSlug();
    }
        
    /**
     * Generate a random string.
     * 
     * @param Integer $length
     * 
     * @return String
     */
    protected function getRandomString($length = 8)
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