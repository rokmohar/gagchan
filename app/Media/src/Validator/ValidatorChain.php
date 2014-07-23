<?php

namespace Media\Validator;

Use Guzzle\Http\Client;
use Guzzle\Http\Exception\RequestException;

use Zend\Validator\AbstractValidator;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class ValidatorChain extends AbstractValidator
{
    /**#@+*/
    const NOT_READABLE = 'fileNotReadable';
    /**#@-*/
    
    /**
     * @var array
     */
    protected $messageTemplates = array(
        self::NOT_READABLE => "File is not readable or does not exist",
    );
    
    /**
     * @var \Guzzle\Http\Client
     */
    protected $guzzle;
    
    /**
     * @var array
     */
    protected $options = array();
    
    /**
     * @var array
     */
    protected $validators = array();
    
    /**
     * @param array $options
     */
    public function __construct($options = array())
    {
        foreach ($options as $k => $v) {
            // Check if value is validator
            if (is_array($v) && isset($v['name'])) {
                $this->validators[] = $v;
                
                unset($options[$k]);
            }
        }
        
        parent::__construct($options);
    }
    
    /**
     * {@inheritDoc}
     */
    public function isValid($value)
    {
        // Get file from URI
        $filename = $this->getFile($value);
        
        if ($filename === null) {
            // Add error
            $this->error(self::NOT_READABLE);
            
            return false;
        }
        
        // Mime type info
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        
        // Construct file data
        $filedata = array(
            'name'     => basename($value),
            'tmp_name' => $filename,
            'type'     => $finfo->file($filename),
            'size'     => filesize($filename),
            'error'    => 0,
        );
        
        foreach ($this->validators as $v) {
            // Check if name is provided
            if (!isset($v['name'])) {
                throw new \InvalidArgumentException(
                    'Validator name must be provided.'
                );
            }
            
            $name    = $v['name'];
            $options = isset($v['options']) ? $v['options'] : array();
            
            $validator = new $name($options);
            
            if (!$validator->isValid($filedata)) {
                // Merge messages
                $this->abstractOptions['messages'] = array_merge(
                    $this->abstractOptions['messages'],
                    $validator->getMessages()
                );
                
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Retrieve a file.
     * 
     * @return mixed
     */
    protected function getFile($uri)
    {
        try {
            // Temporary file
            $filename = tempnam(sys_get_temp_dir(), '');

            // Guzzle
            $guzzle = $this->getGuzzle();

            $guzzle
                ->get($uri)
                ->setResponseBody($filename)
                ->send()
            ;
            
            return $filename;
        }
        catch (RequestException $e) {
            // Ignore exception
        }
        
        return null;
    }
    
    /**
     * Get the guzzle.
     * 
     * @return \Guzzle\Http\Client
     */
    protected function getGuzzle()
    {
        if ($this->guzzle === null) {
            return $this->guzzle = new Client();
        }
        
        return $this->guzzle;
    }
}