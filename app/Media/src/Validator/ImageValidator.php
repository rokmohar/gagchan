<?php

namespace Media\Validator;

use Zend\Validator\AbstractValidator;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class ImageValidator extends AbstractValidator
{
    /**
     * Error constants
     */
    const ERROR_NOT_FILE  = 'notFile';
    const ERROR_NOT_IMAGE = 'notImage';
    
    /**
     * Error messages
     */
    protected $messageTemplates = array(
        self::ERROR_NOT_FILE  => 'Given resource is not a file',
        self::ERROR_NOT_IMAGE => 'Given resource is not an image file',
    );
    
    /**
     * {@inheritDoc}
     */
    public function isValid($value)
    {
        // Check if value is a file
        if ($this->isFile($value) === false) {
            // Set error message
            $this->error(self::ERROR_NOT_FILE);
            
            // Invalid  resource
            return false;
        }
        
        // Temporary file
        $temp = tempnam(sys_get_temp_dir(), '');

        // Copy file from provided URL
        copy($value, $temp);
        
        // Get image typ if file is an image
        $isImage = exif_imagetype($temp);
        
        // Delete file
        unset($temp);
        
        // Check if file is an image
        if ($isImage === false) {
            // Set error message
            $this->error(self::ERROR_NOT_IMAGE);
            
            // Invalid  resource
            return false;
        }
        
        // Valid resource
        return true;
    }
    
    /**
     * Check if resource is a file.
     * 
     * @param String $filename
     * 
     * @return Boolean
     */
    protected function isFile($filename)
    {
        // Initialize cURL connection
        $ch = curl_init($filename);
        
        // Execute cURL command
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        
        // Get HTTP code from cURL
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Close cURL connection
        curl_close($ch);
        
        // Check if file was retrieved
        return ($code === 200);
    }
}