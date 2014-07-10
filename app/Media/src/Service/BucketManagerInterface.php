<?php

namespace Media\Service;

use Media\Mapper\MediaMapperInterface;

interface BucketManagerInterface
{
    /**
     * @return \Media\Mapper\MediaMapperInterface
     */
    public function getMediaMapper();
    
    /**
     * @param \Media\Mapper\MediaMapperInterface $mediaMapper
     * 
     * @return \Media\Service\BucketManager
     */
    public function setMediaMapper(MediaMapperInterface $mediaMapper);
}
