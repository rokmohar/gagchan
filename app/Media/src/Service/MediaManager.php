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
     * @var Array
     */
    protected $animationMimeType = array(
        'image/gif',
    );
    
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
    public function uploadImage(
        UploadedFile $file,
        $name,
        UserEntityInterface $user,
        CategoryEntityInterface $category
    ) {
        // Check if image is animation
        if (in_array($file->getMimeType(), $this->animationMimeType)) {
            // Upload animation
            return $this->uploadAnimation($file, $name, $user, $category);
        }
        
        // Resize image
        $this->resizeImage($file);
        
        // Get unique slug
        $slug = $this->getUniqueSlug();
        
        // Insert image data into DB
        $this->insertData($file, $slug, $name, $user, $category);
        
        // Storage
        $storage = $this->getStorageManager()->getStorage('amazon');
        
        // Upload file to the storage
        $storage->putFile(
            sprintf("photo/%s_460s.%s", $slug, $file->guessExtension()),
            $file
        );
        
        return $this;
    }
    
    /**
     * Upload file to the storage.
     * 
     * @param \Core\File\UploadedFile                  $file
     * @param String                                   $name
     * @param \ZfcUser\Entity\UserInterface            $user
     * @param \Category\Entity\CategoryEntityInterface $category
     * 
     * @return \Media\Service\MediaManagerInterface
     */
    protected function uploadAnimation(
        UploadedFile $file,
        $name,
        UserEntityInterface $user,
        CategoryEntityInterface $category
    ) {
        // Get thumbnail
        $thumbnail = $this->copyFile($file);
        
        // Resize thumbnail
        $this->resizeImage($thumbnail);

        // Get unique slug
        $slug = $this->getUniqueSlug();

        // Insert image data into DB
        $this->insertData($file, $slug, $name, $user, $category, $thumbnail);

        // Storage
        $storage = $this->getStorageManager()->getStorage('amazon');

        // Resize thumbnail
        $this->resizeImage($thumbnail);

        // Upload file to the storage
        $storage->putFile(
            sprintf("photo/%s_460sa.%s", $slug, $file->guessExtension()),
            $file
        );

        // Upload thumbnail to the storage
        $storage->putFile(
            sprintf("photo/%s_460s_v1.%s", $slug, $thumbnail->guessExtension()),
            $thumbnail
        );

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
     * @param \Core\File\UploadedFile                  $thumbnail
     * 
     * @return \Media\Service\MediaManager
     */
    protected function insertData(
        UploadedFile $file,
        $slug,
        $name,
        UserEntityInterface $user,
        CategoryEntityInterface $category,
        UploadedFile $thumbnail = null
    ) {
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
        
        // Check if image is animation
        if (in_array($file->getMimeType(), $this->animationMimeType)) {
            // Set reference
            $media->setReference(
                sprintf("/photo/%s_460sa.%s", $slug, $file->guessExtension())
            );

            // Set thumbnail
            $media->setThumbnail(
                sprintf("/photo/%s_460s_v1.%s", $slug, $thumbnail->guessExtension())
            );
        }
        else {
            // Set reference
            $media->setReference(
                sprintf("/photo/%s_460s.%s", $slug, $file->guessExtension())
            );
        }
        
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
     * Copy a file.
     * 
     * @param \Core\File\UploadedFile $file
     * 
     * @return \Core\File\UploadedFile
     */
    protected function copyFile(UploadedFile $file)
    {
        // Temporary file
        $temp = tempnam(sys_get_temp_dir(), '');

        // Copy file contents
        copy($file, $temp);

        // Return uploaded file
        return new \Core\File\UploadedFile(
            $temp,
            $file->getOriginalName(),
            $file->getMimeType(),
            $file->getSize()
        );
    }
    
    /**
     * Resize an image.
     * 
     * @param \Core\File\UploadedFile $file
     * 
     * @return \Media\Service\MediaManager
     */
    protected function resizeImage(UploadedFile $file, $width = null, $height = null)
    {
        // Get image
        $imagine = $this->getImagine();
        
        // Open image file with imagine
        $image = $imagine->open($file->getPathname());
        
        // Get image sizes
        $size = $image->getSize();
        
        // Check if width is not given
        if (!is_integer($width) && is_integer($height)) {
            // Set new width
            $width = $size->getWidth() * $height / $size->getHeight();
        }
        else if (!is_integer($width)) {
            // Set to default width
            $width = 460;
        }
        
        // Check if height is not given
        if (!is_integer($height) && is_integer($width)) {
            // Calculate height
            $height = $size->getHeight() * $width / $size->getWidth();
        }
        else if (!is_integer($height)) {
            // Set default height
            $height = 460;
        }
        
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
     * {@inheritDoc}
     */
    public function getMediaMapper()
    {
        return $this->mediaMapper;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getStorageManager()
    {
        return $this->storageManager;
    }
}