<?php

namespace Core\File;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class UploadedImage extends UploadedFile
{
    /**
     * @var int
     */
    protected $width;
    
    /**
     * @var int
     */
    protected $height;
    
    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }
    
    /**
     * @param int $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }
    
    /**
     * @param int $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
        
        return $this;
    }
}