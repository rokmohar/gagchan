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
     * @var \Media\Options\ModuleOptions
     */
    protected $options;
    
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
        
        $client->getObject(array(
            'Bucket' => $this->getOptions()->getBucket(),
            'Key'    => $key,
        ));
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function putFile($key, UploadedFile $file)
    {
        $client = $this->getAws()->get('s3');
        
        $client->putObject(array(
            'ACL'         => 'public-read',
            'Body'        => fopen($file->getPathname(), 'r'),
            'Bucket'      => $this->getOptions()->getBucket(),
            'ContentType' => $file->getMimeType(),
            'Key'         => $key,
        ));
        
        return $this;
    }
    
    /**
     * @return \Aws\Common\Aws
     */
    public function getAws()
    {
        if ($this->aws === null) {
            return $this->aws = $this->serviceLocator->get('aws');
        }
        
        return $this->aws;
    }
    
    /**
     * @return \Media\Options\ModuleOptions
     */
    public function getOptions()
    {
        if ($this->options === null) {
            return $this->options = $this->serviceLocator->get(
                'media.options.module'
            );
        }
        
        return $this->options;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'amazon';
    }
}