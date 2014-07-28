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
     * @var string
     */
    private $font;

    /**
     * @var Image
     */
    protected $img;

    /**
     * @var int
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
     * @param string $name
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

        // Return the path to created image
        return $relPath;
    }

    /**
     * Work on image
     *
     * @param string  $text
     * @param int $size
     * @param string  $type
     */
    private function addText($text, $size, $type)
    {
        // Set vertical margin (10px)
        if($type == 'topText') {
            $textHeight = 30 + 10;
        }
        else {
            $textHeight = $this->getHeight() - (8 + 10);
        }

        while (true) {
            // Calculate text bounding box
            $coords = $this->getFontCoords($text, $size);

            // Place the text in center
            if($type == 'topText') {
                $topTextX = $this->getHorizontalAlignment(
                    $this->getWidth(),
                    $coords[4]
                );
            }
            else {
                $bottomTextX = $this->getHorizontalAlignment(
                    $this->getWidth(),
                    $coords[4]
                );
            }

            //Check if the text exceed image width
            if (!$this->isTextInsideImage(
                $this->getWidth(),
                $coords[2] - $coords[0]
            )) {
                // Downsize text size
                if($type == 'topText') {
                    // If it is top text take it up as font size decreases
                    $textHeight = $textHeight - 1; 		
                }
                else {
                    // If it is bottom text take it down as font size decreases
                    $textHeight = $textHeight + 1; 				
                }

                 // Minimum font, then break into lines
                if ($size <= 20) {
                    if ($type == 'topText') {
                        $this->setTopText($this->breakInLines($text, $type, (20 + 10)));
                        $text = $this->getTopText();

                        return;
                    }
                    else {
                        $this->setBottomText($this->breakInLines($text, $type, $this->getHeight() - (8 + 10)));
                        $text = $this->getBottomText();

                        return;
                    }
                }
                else {
                    // Decrease the font size
                    $size = $size - 1;
                }

            }
            else {
                break;
            }
        }

        // Place text
        if($type == 'topText') {
            $this->placeTextOnImage(
                $size,
                $topTextX,
                $textHeight,
                $this->getFont(),
                $this->getTopText()
            );
        }
        else {
            $this->placeTextOnImage(
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
     * @param string  $text
     * @param string  $type
     * @param int     $textHeight
     *
     * @return string
     */
    private function breakInLines($text, $type, $textHeight)
    {
        // Break text into words
        $brokenText = explode(' ', $text);
        
        // Multiline text
        $multilineText = '';
        
        // Count number of lines
        $lines = $this->countLines($brokenText);
                 
        if ($type != 'topText') {
            // Get text height, based on number of lines
            $textHeight = $this->getHeight() - ($lines * 26) - 10;
        }

        foreach ($brokenText as $i=>$i) {
            
            $temp           = $multilineText;
            $multilineText .= $brokenText[$i] . ' ';

            // Get the sentence placement coordinates
            $dimensions = $this->getFontCoords($multilineText, 20);

            // Check if the sentence is exceeding the image with new word appended
            if (!$this->isTextInsideImage($this->getWidth(),
                                $dimensions[2] - $dimensions[0])
                ) {
                // Append new word
                $dimensions = $this->getFontCoords($temp, 20);
                $locx       = $this->getHorizontalAlignment($this->getWidth(), $dimensions[4]);

                // Place new word on image
                $this->placeTextOnImage(
                    20,
                    $locx,
                    $textHeight,
                    $this->getFont(),
                    $temp
                );

                $multilineText = $brokenText[$i];

                // Line height (go to new line)
                $textHeight    = $textHeight + 26;
            } 

            // Last word
            if ($i == count($brokenText) - 1) {
                $dimensions = $this->getFontCoords($multilineText, 20);
                $locx       = $this->getHorizontalAlignment($this->getWidth(), $dimensions[4]);

                // Place last word on image
                $this->placeTextOnImage(
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
     * Return number of lines for given text (seperated by spaces)
     * 
     * @param String $brokenTxt
     * @return Integer
     */
    private function countLines($brokenTxt)
    {
        $lines = 0;
        $multilineTxt = '';
        
        foreach ($brokenTxt as $i=>$i) {
            
            $tmp           = $multilineTxt;
            $multilineTxt .= $brokenTxt[$i] . ' ';             
                          
            // Get the sentence placement coordinates
            $dim = $this->getFontCoords($multilineTxt, 20);
             
            // Check if the sentence is exceeding the image with new word appended
            if (!$this->isTextInsideImage($this->getWidth(), $dim[2] - $dim[0])) {
                // Append new word
                $dim = $this->getFontCoords($tmp, 20);
                $multilineTxt = $brokenTxt[$i];
                
                // New line
                $lines++;
            }
                    
        }  
        
        // Return number of lines
        return $lines;
    }
    
    /**
     * Retrun image from given path
     *
     * @param string $path
     * 
     * @return resource
     */
    private function returnImageFromPath($path)
    {
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        if ($ext == 'jpg' || $ext == 'jpeg') {
            // Create a new image from JPEG
            return imagecreatefromjpeg($path);

        }
        else if($ext == 'png') {
            // Create a new image from PNG
            return imagecreatefrompng($path);

        }
        else if($ext == 'gif') {
            // Create a new image from GIF
            return imagecreatefromgif($path);

        }
    }

    /**
     * Place text on image
     *
     * @param int    $fontsize
     * @param int    $x
     * @param int    $y
     * @param string $font
     * @param string $text
     */
    private function placeTextOnImage($fontsize, $x, $y, $font, $text)
    {
        // Stroke width in pixels
        $stroke = 1;

        // Draw the outline stroke on the text
        for ($ox = -$stroke; $ox <= $stroke; $ox++) {
            for ($oy = -$stroke; $oy <= $stroke; $oy++) {
                imagettftext(
                    $this->getImage(),
                    $fontsize,
                    0, $x + $ox,
                    $y + $oy,
                    $this->getStrokeColor(),
                    $font,
                    $text
                );
            }
        }

        // Write the given text into the image
        imagettftext(
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
     * @param int $imgWidth
     * @param int $fontWidth
     * 
     * @return boolean
     */
    private function isTextInsideImage($imgWidth, $fontWidth)
    {
        if($imgWidth < $fontWidth + 20) {
            return false;
        }

        return true;
    }

    /**
     * Get horizontal text alignment
     *
     * @param int $imgWidth
     * @param int $topRightPixel
     * 
     * @return int
     */
    private function getHorizontalAlignment($imgWidth, $topRightPixel)
    {
        return ceil($imgWidth / 2 - $topRightPixel / 2);
    }

    /**
     * Calculate the bounding box of a text
     *
     * @param string $text
     * @param int    $size
     * 
     * @return int
     */
    private function getFontCoords($text, $size)
    {
        // Return the bounding box in pixels
        return imagettfbbox($size, 0, $this->getFont() , $text);
    }

    /**
     * @return int
     */
    public function getBackground()
    {
        return $this->background;
    }

    /**
     * @param string $path
     */
    public function setBackground($path)
    {
        $this->background = imagecolorallocate($path, 255, 255, 255);

        return $this;
    }

    /**
     * @return resource
     */
    public function getImage()
    {
        return $this->img;
    }

    /**
     * @param string $path
     */
    public function setImage($path)
    {
        $this->img = $this->returnImageFromPath($path);

        return $this;
    }

    /**
     * @return array
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param string $path
     */
    public function setSize($path)
    {
        $this->size = getimagesize($path);

        return $this;
    }

    /**
     * @return int
     */
    public function getStrokeColor()
    {
        return $this->strokeColor;
    }

    /**
     *
     * @param string $path
     */
    public function setStrokeColor($path)
    {
        $this->strokeColor = imagecolorallocate($path, 0, 0, 0);

        return $this;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return isset($this->size[0]) ? $this->size[0] : null;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return isset($this->size[1]) ? $this->size[1] : null;
    }

    /**
     * @return string
     */
    public function getFont()
    {
        return $this->font;
    }

    /**
     * @param string $font
     */
    public function setFont($font)
    {
        $this->font = $font;

        return $this;
    }

    /**
     * @return string
     */
    public function getTopText()
    {
        return $this->topText;
    }

    /**
     * @param string $text
     */
    public function setTopText($text)
    {
        $this->topText = strtoupper($text);

        return $this;
    }

    /**
     * @return string
     */
    public function getBottomText()
    {
        return $this->bottomText;
    }

    /**
     * @param string $text
     */
    public function setBottomText($text)
    {
        $this->bottomText = strtoupper($text);

        return $this;
    }
}
