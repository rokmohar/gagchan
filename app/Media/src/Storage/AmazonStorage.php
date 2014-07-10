<?php

namespace Media\Storage;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class AmazonStorage implements StorageInterface
{
    /**
     * @var \Aws\Common\Aws
     */
    protected $aws;
    
    /**
     * @param \Aws\Common\Aws $aws
     */
    public function __construct(Aws $aws)
    {
        $this->aws = $aws;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getFile($key)
    {
        $client = $this->getAws()->get('s3');
        
        return $client->getObject(array(
            'Bucket' => 'gagchan/photo',
            'Key'    => $key,
        ));
    }
    
    /**
     * {@inheritDoc}
     */
    public function putFile($key, $filename)
    {
        $client = $this->getAws()->get('s3');
        
        $client->putObject(array(
            'Bucket' => 'gagchan/photo',
            'Key'    => $key,
            'Body'   => fopen($filename, 'r'),
            'ACL'    => 'public-read',
        ));
        
        return $this;
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
     * @return String
     */
    public function getName()
    {
        return 'amazon';
    }
}