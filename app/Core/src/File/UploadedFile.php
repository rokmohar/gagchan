<?php

namespace Core\File;

use Core\File\MimeType\ExtensionGuesserInterface;
use Core\File\MimeType\MimeTypeExtensionGuesser;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class UploadedFile extends \SplFileInfo
{
    /**
     * @var \Core\File\MimeType\ExtensionGuesserInterface
     */
    protected $extensionGuesser;
    
    /**
     * @var String
     */
    protected $originalName;
    
    /**
     * @var String
     */
    protected $mimeType;
    
    /**
     * @var String
     */
    protected $size;
    
    /**
     * @param String  $filename
     * @param String  $originalName
     * @param String  $mimeType
     * @param Integer $size
     * @param Integer $error
     */
    public function __construct($filename, $originalName, $mimeType, $size)
    {
        parent::__construct($filename);
        
        $this->originalName = $originalName;
        $this->mimeType     = $mimeType;
        $this->size         = $size;
    }
    
    /**
     * @return mixed
     */
    public function guessExtension()
    {
        return $this->getExtensionGuesser()->guess($this->getMimeType());
    }
    
    /**
     * @return String
     */
    public function getExtension()
    {
        return pathinfo($this->originalName, PATHINFO_EXTENSION);
    }
    
    /**
     * @return \Core\File\MimeType\ExtensionGuesserInterface
     */
    public function getExtensionGuesser()
    {
        if (!$this->extensionGuesser instanceof ExtensionGuesserInterface) {
            return $this->extensionGuesser = new MimeTypeExtensionGuesser();
        }
        
        return $this->extensionGuesser;
    }
    
    /**
     * @return String
     */
    public function getOriginalName()
    {
        return $this->originalName;
    }
    
    /**
     * @param String $originalName
     */
    public function setOriginalName($originalName)
    {
        $this->originalName = $originalName;
        
        return $this;
    }
    
    /**
     * @return String
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }
    
    /**
     * @param String $mimeType
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
        
        return $this;
    }
    
    /**
     * @return Integer
     */
    public function getSize()
    {
        return $this->size;
    }
    
    /**
     * @param Integer $size
     */
    public function setSize($size)
    {
        $this->size = $size;
        
        return $this;
    }
}