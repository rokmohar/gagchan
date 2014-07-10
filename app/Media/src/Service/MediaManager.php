<?php

namespace Media\Service;

use Media\Mapper\MediaMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class MediaManager implements MediaManagerInterface
{
    /**
     * @var \Media\Mapper\MediaMapperInterface
     */
    protected $mediaMapper;
    
    /**
     * @var \Media\Mapper\MediaMapperInterface $mediaMapper
     */
    public function __construct(MediaMapperInterface $mediaMapper)
    {
        $this->mediaMapper = $mediaMapper;
    }
    
    /**
     * Generate a random string.
     * 
     * @param Integer $length
     * 
     * @return String
     */
    function generateString($length = 8)
    {
        $chars  = '0123456789abcdefghijklmnopqrstuvwxyz';
        $string = '';
        
        for ($i = 0; $i < $length; $i++) {
            $string .= $chars[mt_rand(0, strlen($chars) - 1)];
        }

        return $string;
    }
    
    
    /**
     * @return \Media\Mapper\MediaMapperInterface
     */
    public function getMediaMapper()
    {
        return $this->mediaMapper;
    }
}