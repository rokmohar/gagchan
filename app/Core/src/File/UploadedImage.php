<?php

namespace Core\File;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class UploadedImage extends UploadedFile
{
    /**
     * @var Integer
     */
    protected $width;
    
    /**
     * @var Integer
     */
    protected $height;
    
    /**
     * @return Integer
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
     * @return Integer
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