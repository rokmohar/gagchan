<?php

namespace Generator\Utils;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class MemeGenerator{

    /**
     * @var Image
     */
    protected $img;
    
    /**
     * @var Integer
     */
    protected $size;
    
    /**
     * @var Background
     */
    protected $background;
    
    /**
     * @param string  $path
     */    
    public function __construct($path)
    {        
        $this->img        = $this->ReturnImageFromPath($path);
        $this->size       = getimagesize($path);
        $this->background = imagecolorallocate($this->img, 255, 255, 255);
        
        imagecolortransparent($this->img, $this->background);
    }

}
