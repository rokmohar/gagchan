<?php

namespace Generator\Utils;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class MemeGenerator
{
    /**
     * @var Background
     */
    protected $background;
    
    /**
     * @var String
     */
    private $font;
    
    /**
     * @var Image
     */
    protected $img;
       
    /**
     * @var Integer
     */
    protected $size;
    
    /**
     * @param string  $path
     */    
    public function __construct($path)
    {          
        $this
            ->setImage($path)
            ->setFont()
            ->setSize($path)
            ->setBackground()
        ;
          
        // Define a color as transparent
        imagecolortransparent($this->getImage(), $this->getBackground());
    }
    
   /**
     * Process the image
     * 
     * @param String $name 
     * @return Image
     */
    public function processImg($name)
    {
        // Add extension to the image name
        $name .= '.jpg';
        
        // Top text
        $topText    = $this->getTopText();
        
        // Bottom text
        $bottomText = $this->getBottomText();

        // Add top text, if not empty
        if(!empty($topText)) {
            $this->addText($topText, 30, 'topText');
        }

        // Add bottem text, if not empty
        if(!empty($bottomText)) {
           $this->addText($bottomText, 30, 'bottomText');
        }
        
        // Create a JPEG from given image
        imagejpeg($this->getImage(), $name);
        
        // Free memory associated with image
        imagedestroy($this->getImage());

        // Temporary file
     //   $temp = tempnam(sys_get_temp_dir(), '');

        // Copy file from URL
       //  copy($this->getImage(), $temp);        

        // Return the created image via ajax callback
        echo $name;
    }    
    
    /**
     * Work on image
     * 
     * @param String  $text
     * @param Integer $size
     * @param String  $type
     */
    private function addText($text, $size, $type)
    {
        // Set Y coordinates of text
        if($type == 'topText') {
            $textHeight = 35;
        } else {
            $textHeight = $this->getHeight() - 20;
        }

        while (true) {
            // Calculate text bounding box
            $coords = $this->getFontCoords($text, $size);

            // Place the text in center
            if($type == 'topText') {
                $topTextX = $this->getHorizontalAlignment($this->getWidth(), $coords[4]);
            } else {
                $bottomTextX = $this->getHorizontalAlignment($this->getWidth(), $coords[4]); 
            }

            //Check if the text exceed image width
            if ($this->checkTextWidthExceedImage($this->getWidth(), $coords[2] - $coords[0])) {
                // Downsize text size
                if($type == 'topText') {
                    // If it is top text take it up as font size decreases
                    $textHeight = $textHeight - 1; 		
                } else {
                    // If it is bottom text take it down as font size decreases
                    $textHeight = $textHeight + 1; 				
                }

                 // Break into lines
                if ($size == 10) {
                   
                    if($type == 'topText') {
                        $this->setTopText($this->breakInLines($text, $type, 16));
                        $text = $this->getTopText();
                        
                        return;
                    } else {
                        $this->setBottomText($this->breakInLines($text, $type, $this->getHeight() - 20));
                        $text = $this->getBottomText();
                        
                        return;
                    }
                } else {
                    // Decrease the font size
                    $size -=1;
                }

            } else {
                break;
            }
        }

        if($type == 'topText') {
            // Place top text
            $this->placeTextOnImage(
                $this->getImage(), 
                $size, 
                $topTextX, 
                $textHeight, 
                $this->getFont(), 
                $this->getTopText()
            );
        } else {
            // Place bottom text
            $this->placeTextOnImage(
                $this->getImage(), 
                $size, 
                $bottomTextX,
                $textHeight,
                $this->getFont(),
                $this->getBottomText()
            );
        }
    }
    
    /**
     * Break text into multiple lines
     * 
     * @param String  $text
     * @param String  $type
     * @param Integer $textHeight
     * 
     * @return String
     */
    private function breakInLines($text, $type, $textHeight)
    {
        // Break text into words
        $brokenText = explode(' ', $text);
        
        // Multiline text
        $multilineText = '';

        if ($type != 'topText') {
            $textHeight = $this->getHeight() - ((count($brokenText) / 2) * 3);
        }

        for ($i = 0; $i < count($brokenText); $i++) {	
            $temp         = $multilineText;
            $multilineText .= $brokenText[$i] . ' ';
            
            // Get the sentence placement coordinates
            $dimensions = $this->getFontCoords($multilineText, 10);

            // Check if the sentence is exceeding the image with new word appended
            if ($this->checkTextWidthExceedImage(
                    $this->getWidth(), 
                    $dimensions[2] - $dimensions[0])
                ) {
                
                // Append new word
                $dimensions = $this->getFontCoords($temp, 10);
                $locx       = $this->getHorizontalAlignment($this->getWidth(), $dimensions[4]);
                
                $this->placeTextOnImage(
                    $this->getImage(), 
                    10, 
                    $locx, 
                    $textHeight, 
                    $this->getFont(), 
                    $temp
                );
                
                $multilineText = $brokenText[$i];
                $textHeight  += 13;
            }

            // Last word
            if ($i == count($brokenText) - 1) {
                $dimensions = $this->getFontCoords($multilineText, 10);
                $locx       = $this->getHorizontalAlignment($this->getWidth(), $dimensions[4]);
                
                $this->placeTextOnImage(
                    $this->getImage(), 
                    10, 
                    $locx, 
                    $textHeight, 
                    $this->getFont(), 
                    $multilineText
                );
            }
        }
        
        // Return text in multiple lines
        return $multilineText;		
    }      
    
    /**
     * Retrun image from given path
     * 
     * @param String $path
     * @return Image
     */
    private function returnImageFromPath($path)
    {
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        if ($ext == 'jpg' || $ext == 'jpeg') {
            // Create a new image from JPEG
            return imagecreatefromjpeg($path);

        } else if($ext == 'png') {
            // Create a new image from PNG
            return imagecreatefrompng($path);

        } else if($ext == 'gif') {
            // Create a new image from GIF
            return imagecreatefromgif($path);
            
        }
    }    
    
    /**
     * Place text on image
     * 
     * @param Image   $img
     * @param Integer $fontsize
     * @param Integer $x
     * @param Integer $y
     * @param Font    $font
     * @param String  $text
     */
    private function placeTextOnImage
    (
        $img, 
        $fontsize, 
        $x, 
        $y, 
        $font, 
        $text
    )
    {
        // Write the given text into the image
        imagettftext
        (
            $this->getImage(),
            $fontsize,
            0,
            $x,
            $y,
            (int) $this->getBackground(), 
            $font, 
            $text
        );		
    }    
            
    /**
     * Check if the text width exceed the image
     * 
     * @param Integer $imgWidth
     * @param Integer $fontWidth
     * @return boolean
     */
    private function checkTextWidthExceedImage($imgWidth, $fontWidth) 
    {
        if($imgWidth < $fontWidth + 20 ) {
            return true;
        } 
        
        return false;
    }      
    
    /**
     * Get horizontal text alignment
     * 
     * @param Integer $imgWidth
     * @param Integer $topRightPixel
     * @return Integer
     */    
    private function getHorizontalAlignment($imgWidth, $topRightPixel)
    {
        return ceil(($imgWidth - $topRightPixel) / 2);
    }  
    
    /**
     * Calculate the bounding box of a text
     * 
     * @param String $text
     * @param Int    $fontSize
     * @return Integer
     */
    private function getFontCoords($text, $fontSize)
    {
        // Return the bounding box in pixels
        return imagettfbbox($fontSize, 0, $this->getFont() , $text);
    }   
    
    /**
     * {@inheritDoc}
     */    
    public function getBackground()
    {
        return $this->background;
    }    
    
    /**
     * @return \Generator\Utils\MemeGenerator
     */
    public function setBackground()
    {
        $image = $this->getImage();
        
        $this->background = imagecolorallocate($image, 255, 255, 255);
        
        return $this;
    }    
    
    /**
     * {@inheritDoc}
     */    
    public function getImage()
    {
        return $this->img;
    }
    
    /**
     * @param String $path
     * @return \Generator\Utils\MemeGenerator
     */
    public function setImage($path)
    {
        $this->img = $this->returnImageFromPath($path);
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     * @return array
     */    
    public function getSize()
    {
        return $this->size;
    }    
    
    /**
     * {@inheritDoc}
     */     
    public function getWidth()
    {
        // Return height
        return $this->size[0];
    }
    
    /**
     * {@inheritDoc}
     */     
    public function getHeight()
    {
        // Return width
        return $this->size[1];
    }

    /**
     * @param String $path
     * @return \Generator\Utils\MemeGenerator
     */
    public function setSize($path)
    {
        $this->size = getimagesize($path);
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */      
    public function getFont()
    {
        return $this->font;
    }
    
    /**
     * @return \Generator\Utils\MemeGenerator
     */
    public function setFont()
    {
        $this->font = 'public/fonts/impact.ttf';
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */    
    public function getTopText()
    {
        return $this->topText;
    }    
    
    /**
     * @param String $txt
     * @return \Generator\Utils\MemeGenerator
     */
    public function setTopText($txt) 
    { 
        // Transform to uppercase
        $this->topText = strtoupper($txt); 
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */    
    public function getBottomText()
    {
        return $this->bottomText;
    }      
    
    /**
     * @param String $txt
     * @return \Generator\Utils\MemeGenerator
     */
    public function setBottomText($txt)
    { 
        // Transform to uppercase
        $this->bottomText = strtoupper($txt);   
        
        return $this;
    }       
    
}
