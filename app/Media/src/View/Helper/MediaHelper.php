<?php

namespace Media\View\Helper;

use Zend\View\Helper\AbstractHelper;

use Media\Mapper\MediaMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class MediaHelper extends AbstractHelper
{
    /**
     * @var String
     */
    protected $bucketUrl = 'http://d35c4l01ornghz.cloudfront.net/photo/';
    
    /**
     * @var \Media\Mapper\MediaMapperInterface
     */
    protected $mediaMapper;
    
    /**
     * @param \Media\Mapper\MediaMapperInterface $mediaMapper
     */
    public function __construct(MediaMapperInterface $mediaMapper)
    {
        $this->mediaMapper = $mediaMapper;
    }
    
    /**
     * __invoke
     *
     * @return \ZfcUser\Entity\UserInterface
     */
    public function __invoke()
    {
        return $this;
    }
    
    /**
     * Generate URL for media.
     * 
     * @param mixed
     * 
     * @return String
     */
    public function url($media)
    {
        return $this->bucketUrl . $media['reference'];
    }
}