<?php

namespace Media\Factory\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Media\Service\MediaManager;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class MediaManagerFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Media mapper
        $mediaMapper = $serviceLocator->get('media.mapper.media');
        
        // Create and return service
        return new MediaManager($mediaMapper);
    }
}