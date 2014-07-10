<?php

namespace Core\File;

class UploadedFile extends \SplFileInfo
{
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
     * @var String
     */
    protected $error;
    
    /**
     * @param String  $filename
     * @param String  $originalName
     * @param String  $mimeType
     * @param Integer $size
     * @param Integer $error
     */
    public function __construct($filename, $originalName, $mimeType, $size, $error)
    {
        parent::__construct($filename);
        
        $this->originalName = $originalName;
        $this->mimeType     = $mimeType;
        $this->size         = $size;
        $this->error        = $error;
    }
    
    /**
     * @return String
     */
    public function getExtension()
    {
        return pathinfo($this->originalName, PATHINFO_EXTENSION);
    }
    
    /**
     * @return String
     */
    public function getOriginalName()
    {
        return $this->originalName;
    }
    
    /**
     * @return String
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }
    
    /**
     * @return Integer
     */
    public function getSize()
    {
        return $this->size;
    }
    
    /**
     * @return Integer
     */
    public function getError()
    {
        return $this->error;
    }
}