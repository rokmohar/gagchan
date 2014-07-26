<?php

namespace Generator\Utils;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class MemeGenerator
{
    /**
     * @var Color
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
     *
     * @var Color
     */
    protected $strokeColor;
    
    /**
     * @param string  $path
     */    
    public function __construct($path)
    {          
        $this
            ->setImage($path)
            ->setFont('public/fonts/impact.ttf')
            ->setSize($path)
            ->setBackground($this->getImage())
            ->getStrokeColor($this->getImage())
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
        // Location of created image
        $location = '/media/generator/';
        
        // Relative path to the file
        $relPath = $location . $name . '.jpg';
        
        // Absolute path to the file
        $absPath = 'public' . $relPath;
        
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
        imagejpeg($this->getImage(), $absPath);
        
        // Free memory associated with image
        imagedestroy($this->getImage());

        // Copy file from URL
       //  copy($this->getImage(), $temp);      
        
        // Delete the image

        // Return the path to created image
        return $relPath;
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
            $textHeight = 40;
        } else {
            $textHeight = $this->getHeight() - 14;
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
            if ($this->isTextInsideImage($this->getWidth(), $coords[2] - $coords[0])) {
                // Downsize text size
                if($type == 'topText') {
                    // If it is top text take it up as font size decreases
                    $textHeight = $textHeight - 1; 		
                } else {
                    // If it is bottom text take it down as font size decreases
                    $textHeight = $textHeight + 1; 				
                }

                 // Minimum font, then break into lines
                if ($size <= 20) {
                    
                    if ($type == 'topText') {
                        $this->setTopText($this->breakInLines($text, $type, 30));
                        $text = $this->getTopText();
                        
                        return;
                    } else {
                        $this->setBottomText($this->breakInLines($text, $type, $this->getHeight() - 14));
                        $text = $this->getBottomText();
                        
                        return;
                    }
                } else {
                    // Decrease the font size
                    $size = $size - 1;
                }

            } else {
                break;
            }
        }

        // Place top text
        if($type == 'topText') {
            $this->placeTextOnImage($this->getImage(), $size, $topTextX, 
                $textHeight, $this->getFont(),  $this->getTopText());
                        
        // Place bottom text
        } else {
            $this->placeTextOnImage($this->getImage(), $size, $bottomTextX,
                $textHeight, $this->getFont(), $this->getBottomText());
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
            // Get text height base on number of words
            $textHeight = $this->getHeight() - ((count($brokenText) / 2) * 3);
        }

        for ($i = 0; $i < count($brokenText); $i++) {	
            
            $temp           = $multilineText;
            $multilineText .= $brokenText[$i] . ' ';
            
            // Get the sentence placement coordinates
            $dimensions = $this->getFontCoords($multilineText, 20);

            // Check if the sentence is exceeding the image with new word appended
            if ($this->isTextInsideImage(
                    $this->getWidth(), 
                    $dimensions[2] - $dimensions[0])
                ) {
                
                // Append new word
                $dimensions = $this->getFontCoords($temp, 20);
                $locx       = $this->getHorizontalAlignment($this->getWidth(), $dimensions[4]);
                
                $this->placeTextOnImage(
                    $this->getImage(), 
                    20, 
                    $locx, 
                    $textHeight, 
                    $this->getFont(), 
                    $temp
                );
                
                $multilineText = $brokenText[$i];
                
                // Line height
                $textHeight    = $textHeight + 26;
            }

            // Last word
            if ($i == count($brokenText) - 1) {
                $dimensions = $this->getFontCoords($multilineText, 20);
                $locx       = $this->getHorizontalAlignment($this->getWidth(), $dimensions[4]);
                
                $this->placeTextOnImage(
                    $this->getImage(), 
                    20, 
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
        // Stroke width in pixels
        $stroke = 1;
        
        // Draw the outline stroke on the text
        for ($ox = -$stroke; $ox <= $stroke; $ox++) {
            for ($oy = -$stroke; $oy <= $stroke; $oy++) {
                imagettftext($this->getImage(), $fontsize, 0, $x+$ox, $y+$oy, 
                                $this->getStrokeColor(), $font, $text);
            }
        }           
        
        // Write the given text into the image
        imagettftext($this->getImage(), $fontsize, 0, $x, $y,
            (int) $this->getBackground(), $font,  $text);		
    }    
            
    /**
     * Check if the text width exceed the image
     * 
     * @param Integer $imgWidth
     * @param Integer $fontWidth
     * @return boolean
     */
    private function isTextInsideImage($imgWidth, $fontWidth) 
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
     * @param Image $img
     * @return \Generator\Utils\MemeGenerator
     */
    public function setBackground($img)
    {
        $this->background = imagecolorallocate($img, 255, 255, 255);
        
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
    public function getStrokeColor()
    {
        return $this->strokeColor;
    }

    /**
     * 
     * @param Image $img
     * @return \Generator\Utils\MemeGenerator
     */
    public function setStrokeColor($img) 
    {
        $this->strokeColor = imagecolorallocate($img, 0, 0, 0);    
        
        return $this;
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
     * {@inheritDoc}
     */      
    public function getFont()
    {
        return $this->font;
    }
    
    /**
     * @return \Generator\Utils\MemeGenerator
     */
    public function setFont($fontPath)
    {
        $this->font = $fontPath;
        
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
