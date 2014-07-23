<?php

namespace Generator\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class ModuleOptions extends AbstractOptions
{
    /**
     * @var bool
     */
    protected $__strictMode__ = false;
    
    /**
     * @var string
     */
    protected $bucket = 'gagchan';
    
    /**
     * @var string
     */
    protected $bucketUrl = 'http://cdn.gagchan.com';
    
    /**
     * @return string
     */
    public function getBucket()
    {
        return $this->bucket;
    }
    
    /**
     * @param string $bucket
     */
    public function setBucket($bucket)
    {
        $this->bucket = $bucket;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getBucketUrl()
    {
        return $this->bucketUrl;
    }
    
    /**
     * @param string $bucketUrl
     */
    public function setBucketUrl($bucketUrl)
    {
        $this->bucketUrl = $bucketUrl;
        
        return $this;
    }
}