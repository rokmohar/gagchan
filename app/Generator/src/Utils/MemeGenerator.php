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
    private $font = 'public/fonts/impact.ttf';
    
    /**
     * @var Image
     */
    protected $img;
    
    /**
     * @var Integer 
     */
    private $imgSize;
    
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
            ->img        = $this->returnImageFromPath($path)
            ->size       = getimagesize($path)
            ->background = imagecolorallocate($this->img, 255, 255, 255)
        ;
        
        // Define a color as transparent
        imagecolortransparent($this->img, $this->background);
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
        
        if($this->lowerText != "") {
            $this->workOnImage($this->lowerText, 30, "lower");
        }

        if($this->upperText != "") {
           $this->workOnImage($this->upperText, 30, "upper");
        }
        
        // Create a JPEG from given image
        imagejpeg($this->img, $name);
        
        // Free memory associated with image
        imagedestroy($this->img);

        // Return the created image
        echo $name;
    }    
    
    /**
     * Work on image
     * 
     * @param String  $text
     * @param Integer $size
     * @param String  $type
     */
    private function workOnImage($text, $size, $type)
    {
        // Set text size
        if($type == "upper") {
            $textHeight = 35;
        } else {
            $textHeight = $this->imgSize[1] - 20;
        }

        while (true) {
            // Get coordinate for the text
            $coords = $this->getFontPlacementCoordinates($text,$size);

            // Place the text in center
            if($type == "upper") {
                $upperTextX = $this->getHorizontalTextAlignment($this->imgSize[0], $coords[4]);
            } else {
                $lowerTextX = $this->getHorizontalTextAlignment($this->imgSize[0], $coords[4]); 
            }

            //Check if the text does not exceed image width
            if ($this->checkTextWidthExceedImage($this->imgSize[0],$coords[2] - $coords[0])) {
                // Downsize text size
                if($type == "upper") {
                    $textHeight = $textHeight - 1; 		//if it is top text take it up as font size decreases
                } else {
                    $textHeight = $textHeight + 1; 		//if it is bottom text take it down as font size decreases		
                }

                if ($size == 10) {
                    //if text size is reached to lower limit and still it is exceeding image width start breaking into lines
                    if($type == "upper") {
                        $this->upperText= $this->returnMultipleLinesText($text,$type,16);
                        $text = $this->upperText;
                        return;
                    } else {
                        $this->lowerText= $this->returnMultipleLinesText($text,$type,$this->imgSize[1] - 20);
                        $text = $this->lowerText;
                        return;
                    }
                } else {
                    $size -=1;
                }

            } else {
                break;
            }
        }

        if($type == "upper") {
            $this->placeTextOnImage($this->img,$size, $upperTextX, $textHeight,$this->font, $this->upperText);
        } else {
            $this->placeTextOnImage($this->img,$size, $lowerTextX, $textHeight,$this->font, $this->lowerText);
        }
    }
    
    /**
     * Return multiple lines text
     * 
     * @param String  $text
     * @param String  $type
     * @param Integer $textHeight
     * 
     * @return String
     */
    private function returnMultipleLinesText($text, $type, $textHeight)
    {
        //breaks the whole sentence into multiple lines according to the width of the image.

        //break sentence into an array of words by using the spaces as params
        $brokenText = explode(" ",$text);
        $finalOutput = "";

        if($type != "upper") {
            $textHeight = $this->imgSize[1] - ((count($brokenText)/2) * 3);
        }

        for ($i = 0; $i < count($brokenText); $i++) {	
            $temp         = $finalOutput;
            $finalOutput .= $brokenText[$i] . " ";
            
            // this will help us to keep the last word in hand if this word is the cause of text exceeding the image size.			
            // We will be using this to append in next line.

            //check if word is too long i.e wider than image width

            //get the sentence(appended till now) placement coordinates
            $dimensions = $this->getFontPlacementCoordinates($finalOutput,10);

            //check if the sentence (till now) is exceeding the image with new word appended
            if($this->checkTextWidthExceedImage($this->imgSize[0], $dimensions[2] - $dimensions[0])) {
                
                // append the previous sentence not with the new word  ( new word == $brokenText[$i] )
                $dimensions = $this->getFontPlacementCoordinates($temp,10);
                $locx       = $this->getHorizontalTextAlignment($this->imgSize[0],$dimensions[4]);
                
                $this->placeTextOnImage($this->img,10,$locx,$textHeight,$this->font,$temp);
                $finalOutput = $brokenText[$i];
                $textHeight  += 13;
            }

            //if this is the last word append this also.The previous if will be true if the last word will have no room
            if ($i == count($brokenText) - 1) {
                $dimensions = $this->getFontPlacementCoordinates($finalOutput,10);
                $locx       = $this->getHorizontalTextAlignment($this->imgSize[0],$dimensions[4]);
                $this->placeTextOnImage($this->img,10,$locx,$textHeight,$this->font,$finalOutput);
            }
        }
        
        // Return 
        return $finalOutput;		
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
     * @param Integer $Xlocation
     * @param Integer $textheight
     * @param Font    $font
     * @param String  $text
     */
    private function placeTextOnImage
    (
        $img, 
        $fontsize, 
        $Xlocation, 
        $textheight, 
        $font, 
        $text
    )
    {
        // Write the given text into the image
        imagettftext
        (
            $this->img,
            $fontsize,
            0,
            $Xlocation,
            $textheight,
            (int) $this->background, 
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
        } else { 
            return false;
        }
    }      
    
    /**
     * Get horizontal text alignment
     * 
     * @param Integer $imgWidth
     * @param Integer $topRightPixelOfText
     * @return Double
     */    
    private function getHorizontalTextAlignment($imgWidth, $topRightPixelOfText)
    {
        return ceil(($imgWidth - $topRightPixelOfText) / 2);
    }  
    
    /**
     * 
     * @param String $text
     * @param Int    $fontSize
     * @return Integer
     */
    private function getFontPlacementCoordinates($text, $fontSize)
    {
        /*		returns 
        *		Array
        *		(
        *			[0] => ? // lower left X coordinate
        *			[1] => ? // lower left Y coordinate
        *			[2] => ? // lower right X coordinate
        *			[3] => ? // lower right Y coordinate
        *			[4] => ? // upper right X coordinate
        *			[5] => ? // upper right Y coordinate
        *			[6] => ? // upper left X coordinate
        *			[7] => ? // upper left Y coordinate
        *		)
        **/

        return imagettfbbox($fontSize, 0, $this->font , $text);
    }   
    
    /**
     * Set top text
     * 
     * @param String $txt
     */
    public function setTopText($txt) 
    { 
        $this->upperText = strtoupper($txt); 
    }
    
    /**
     * Set bottom text
     * 
     * @param type $txt
     */
    public function setBottomText($txt)
    { 
        $this->lowerText = strtoupper($txt);   
    }       
    
}
