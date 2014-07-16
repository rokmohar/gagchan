<?php

namespace Media\Storage;

use Zend\ServiceManager\ServiceLocatorInterface;

use Core\File\UploadedFile;

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
            'Bucket' => 'gagchan',
            'Key'    => $key,
        ));
    }
    
    /**
     * {@inheritDoc}
     */
    public function putFile($key, UploadedFile $file)
    {
        $client = $this->getAws()->get('s3');
        
        return $client->putObject(array(
            'Bucket'      => 'gagchan',
            'Key'         => $key,
            'Body'        => fopen($file->getPathname(), 'r'),
            'ContentType' => $file->getMimeType(),
            'ACL'         => 'public-read',
        ));
    }
    
    /**
     * @return \Aws\Common\Aws
     */
    public function getAws()
    {
        if ($this->aws === null) {
            // Load from service locator
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