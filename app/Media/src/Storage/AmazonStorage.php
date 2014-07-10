<?php

namespace Media\Storage;

use Aws\Common\Aws;

use Zend\ServiceManager\ServiceLocatorInterface;

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
     * @var \Zend\ServiceManager\ServiceLocatorInterface
     */
    protected $serviceLocator;
    
    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     */
    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
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
        if (!$this->aws instanceof Aws) {
            return $this->aws = $this->serviceLocator->get('aws');
        }
        
        return $this->aws;
    }
    
    /**
     * @return String
     */
    public function getName()
    {
        return 'amazon';
    }
}