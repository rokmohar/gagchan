<?php

namespace Media\Service;

use Imagine\Image\Box;
use Imagine\Gd\Imagine;

use Core\File\UploadedFile;
use Media\Entity\MediaEntityInterface;
use Media\Mapper\MediaMapperInterface;
use Media\Storage\StorageManagerInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class MediaManager implements MediaManagerInterface
{
    /**
     * @var array
     */
    protected $animation = array('image/gif');
    
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
        MediaEntityInterface $media
    ) {
        // Check if image is animation
        if (in_array($file->guessMimeType(), $this->animation)) {
            // Upload animation
            return $this->uploadAnimation($file, $media);
        }
        
        // Resize image
        $file = $this->resizeImage($file);
        
        // Set slug
        $media->setSlug($this->generateSlug());
        
        // Update metadata
        $this->updateMetadata($media, $file);
        
        // Insert data
        $this->insertData($file, $media);
        
        // Get storage
        $storage = $this->getStorageManager()->getStorage('amazon');
        
        // Upload image
        $storage->putFile(
            sprintf("photo/%s_460s.%s", $media->getSlug(), $file->guessExtension()),
            $file,
            $media
        );
        
        return $this;
    }
    
    /**
     * Upload animation image.
     * 
     * @param \Core\File\UploadedFile            $file
     * @param \Media\Entity\MediaEntityInterface $media
     * 
     * @return \Media\Service\MediaManagerInterface
     */
    public function uploadAnimation(
        UploadedFile $file,
        MediaEntityInterface $media
    ) {
        // Get thumbnail
        $thumbnail = $this->resizeImage($this->copyImage($file));
        
        // Set slug
        $media->setSlug($this->generateSlug());
        
        // Update metadata
        $this->updateMetadata($media, $file);

        // Insert data
        $this->insertData($file, $media, $thumbnail);

        // Get storage
        $storage = $this->getStorageManager()->getStorage('amazon');

        // Upload image
        $storage->putFile(
            sprintf("photo/%s_460sa_v1.%s", $media->getSlug(), $file->guessExtension()),
            $file,
            $media
        );

        // Upload thumbnail
        $storage->putFile(
            sprintf("photo/%s_460s_v1.%s", $media->getSlug(), $thumbnail->guessExtension()),
            $thumbnail,
            $media
        );

        return $this;
    }
    
    /**
     * Copy an image.
     * 
     * @param \Core\File\UploadedFile $file
     * 
     * @return \Core\File\UploadedFile
     */
    protected function copyImage(UploadedFile $file)
    {
        // Temporary file
        if (!$temp = tempnam(sys_get_temp_dir(), '')) {
            // Throw an exception
            throw new \RuntimeException("Could not create a temporary file.");
        }

        // Copy contents
        if (!copy($file, $temp)) {
            // Throw an exception
            throw new \RuntimeException(
                sprintf("Could not copy file \"%s\"."), $file->getFilename()
            );
        }
        
        // Create a copy
        return new UploadedFile(
            $temp,
            $file->getClientOriginalName(),
            $file->getClientMimeType(),
            $file->getClientSize(),
            $file->getError()
        );
    }
    
    /**
     * Get a unique slug.
     * 
     * @return string
     */
    protected function generateSlug()
    {
        // Generate a slug
        $slug = $this->generateString(8);
        
        // Media mapper
        $mediaMapper = $this->getMediaMapper();
        
        // Check if slug is unique
        if ($mediaMapper->isUniqueSlug($slug) === true) {
            // Return unique slug
            return $slug;
        }
        
        // Generate a new slug
        return $this->generateSlug();
    }
        
    /**
     * Generate a random string.
     * 
     * @param int $length
     * 
     * @return string
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
     * Insert a row.
     * 
     * @param \Core\File\UploadedFile            $file
     * @param \Media\Entity\MediaEntityInterface $media
     * @param \Core\File\UploadedFile            $thumbnail
     * 
     * @return \Media\Service\MediaManager
     */
    protected function insertData(
        UploadedFile $file,
        MediaEntityInterface $media,
        UploadedFile $thumbnail = null
    ) {
        // Check if image is animation
        if (in_array($file->guessMimeType(), $this->animation)) {
            // Set reference
            $media->setReference(
                sprintf("/photo/%s_460sa_v1.%s", $media->getSlug(), $file->guessExtension())
            );

            // Set thumbnail
            $media->setThumbnail(
                sprintf("/photo/%s_460s_v1.%s", $media->getSlug(), $thumbnail->guessExtension())
            );
        }
        else {
            // Set reference
            $media->setReference(
                sprintf("/photo/%s_460s.%s", $media->getSlug(), $file->guessExtension())
            );
        }
        
        // Get media mapper
        $mediaMapper = $this->getMediaMapper();
        
        // Insert a row
        return $mediaMapper->insertRow($media);
    }
    
    /**
     * Resize an image.
     * 
     * @param \Core\File\UploadedFile $file
     * @param int                     $height
     * @param int                     $width
     * 
     * @return \Core\File\UploadedFile
     */
    protected function resizeImage(UploadedFile $file, $height = null, $width = null)
    {
        // Get image
        $imagine = $this->getImagine();
        
        // Open image
        $image = $imagine->open($file->getPathname());
        
        // Get size
        $size = $image->getSize();
        
        // Check if width is not given
        if (!is_integer($width) && is_integer($height)) {
            // Calculate width
            $width = $size->getWidth() * $height / $size->getHeight();
        }
        else if (!is_integer($width)) {
            // Set to default
            $width = 460;
        }
        
        // Check if height is not given
        if (!is_integer($height) && is_integer($width)) {
            // Calculate height
            $height = $size->getHeight() * $width / $size->getWidth();
        }
        else if (!is_integer($height)) {
            // Set default
            $height = 460;
        }
        
        // Resize image
        $image
            ->resize(new Box($width, $height))
            ->save($file->getPathname(), array(
                'format' => 'jpg',
            ))
        ;
        
        // Return image
        return $file;
    }
    
    /**
     * Update metadata.
     * 
     * @param \Media\Entity\MediaEntityInterface $media
     * @param \Core\File\UploadedFile            $file
     * 
     * @return \Media\Service\MediaManager
     */
    protected function updateMetadata(
        MediaEntityInterface $media,
        UploadedFile $file
    ) {
        // Get imagine
        $imagine = $this->getImagine();
        
        // Open image
        $image = $imagine->open($file->getPathname());
        
        // Get size
        $size = $image->getSize();
        
        // Set data
        $media->setHeight($size->getHeight());
        $media->setWidth($size->getWidth());
        $media->setSize($file->getSize());
        $media->setContentType($file->guessMimeType());
        
        return $this;
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