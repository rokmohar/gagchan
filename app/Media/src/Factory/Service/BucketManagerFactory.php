<?php

namespace Media\Factory\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Media\Service\BucketManager;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class BucketManagerFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // AWS service
        $aws = $serviceLocator->get('aws');
        
        // Media mapper
        $mediaMapper = $serviceLocator->get('media.mapper.media');
        
        return new BucketManager($aws, $mediaMapper);
    }
}