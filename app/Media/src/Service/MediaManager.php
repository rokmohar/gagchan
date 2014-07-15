<?php

namespace Media\Service;

use Imagine\Gd\Imagine;
use Imagine\Image\Box;

use Core\File\UploadedFile;
use Category\Entity\CategoryEntityInterface;
use Media\Entity\MediaEntity;
use Media\Mapper\MediaMapperInterface;
use Media\Storage\StorageManagerInterface;
use ZfcUser\Entity\UserInterface as UserEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
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
    public function uploadFile(
        UploadedFile $file,
        $name,
        UserEntityInterface $user,
        CategoryEntityInterface $category
    ) {
        // Resize image
        $this->resizeImage($file);
        
        // Get unique slug
        $slug = $this->getUniqueSlug();
        
        // Insert image data into DB
        $this->insertData($file, $slug, $name,  $user, $category);
        
        // Storage
        $storage = $this->getStorageManager()->getStorage('amazon');
        
        // Upload file to the storage
        $storage->putFile($slug, $file);
        
        return $this;
    }
    
    /**
     * Insert a row to data storage.
     * 
     * @param \Core\File\UploadedFile                  $file
     * @param String                                   $slug
     * @param String                                   $name
     * @param \ZfcUser\Entity\UserInterface            $user
     * @param \Category\Entity\CategoryEntityInterface $category
     * 
     * @return \Media\Service\MediaManager
     */
    protected function insertData(UploadedFile $file, $slug, $name, UserEntityInterface $user, CategoryEntityInterface $category)
    {
        // Media mapper
        $mediaMapper = $this->getMediaMapper();
        
        // Imagine
        $imagine = $this->getImagine();
        
        // Open image
        $image = $imagine->open($file->getPathname());
        $size  = $image->getSize();
        
        // Create an entity
        $media = new MediaEntity();
        
        // Set data
        $media->setSlug($slug);
        $media->setName($name);
        
        // Set reference
        $media->setReference(
            sprintf("/photo/%s_460b.%s", $slug, $file->guessExtension())
        );
        
        // Set identifier
        $media->setUserId($user->getId());
        $media->setCategoryId($category->getId());
        
        // Set image data
        $media->setWidth($size->getWidth());
        $media->setHeight($size->getHeight());
        $media->setSize($file->getSize());
        $media->setContentType($file->getMimeType());
        
        // Insert a row
        $mediaMapper->insertRow($media);
        
        return $this;
    }
    
    /**
     * Resize an image.
     * 
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
        if ($this->imagine === null) {
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