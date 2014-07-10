<?php

namespace Media\Service;

use Aws\Common\Aws;

use Media\Mapper\MediaMapperInterface;

class BucketManager implements BucketManagerInterface
{
    /**
     * @var \Aws\Common\Aws
     */
    protected $aws;
    
    /**
     * @var \Media\Mapper\MediaMapperInterface
     */
    protected $mediaMapper;
    
    /**
     * @param Array $options
     */
    protected $options = array(
        'aws' => array(
            'bucket' => 'gagchan/photo',
            'acl'    => 'public-read'
        ),
    );
    
    /**
     * @param \Aws\Common\Aws $aws
     * @param \Media\Mapper\MediaMapperInterface $mediaMapper
     * @param Array                              $options
     */
    public function __construct(Aws $aws, MediaMapperInterface $mediaMapper, array $options = array())
    {
        $this->aws         = $aws;
        $this->mediaMapper = $mediaMapper;
        
        $this->options = array_unique(array_merge(
            $this->options,
            $options
        ));
    }
    
    /**
     * @param String $name
     * @param String $filepath
     * 
     * @return \Media\Service\BucketManager
     */
    public function uploadFile($name, $filepath)
    {
        $client = $this->getAws()->get('s3');
        
        $options = $this->options['aws'];
        
        $client->putObject(array(
            'Bucket' => $options['bucket'],
            'Key'    => $name,
            'Body'   => fopen($filepath, 'r'),
            'ACL'    => $options['acl'],
        ));
        
        return $this;
    }
    
    /**
     * Generate random slug.
     * 
     * @param Integer $length
     * 
     * @return String
     */
    function generateSlug($length = 8) {
        
        $chars  = '0123456789abcdefghijklmnopqrstuvwxyz';
        $string = '';
        
        for ($i = 0; $i < $length; $i++) {
            $string .= $chars[mt_rand(0, strlen($chars) - 1)];
        }

        return $string;
    }
    
    /**
     * @return \Aws\Common\Aws
     */
    public function getAws()
    {
        return $this->aws;
    }
    
    /**
     * @param \Aws\Common\Aws $aws
     * 
     * @return \Media\Service\BucketManager
     */
    public function setAws(Aws $aws)
    {
        $this->aws = $aws;
        
        return $this;
    }
    
    /**
     * @return \Media\Mapper\MediaMapperInterface
     */
    public function getMediaMapper()
    {
        return $this->mediaMapper;
    }
    
    /**
     * @param \Media\Mapper\MediaMapperInterface $mediaMapper
     * 
     * @return \Media\Service\BucketManager
     */
    public function setMediaMapper(MediaMapperInterface $mediaMapper)
    {
        $this->mediaMapper = $mediaMapper;
        
        return $this;
    }
}
