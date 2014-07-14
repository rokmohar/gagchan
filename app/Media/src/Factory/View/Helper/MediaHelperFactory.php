<?php

namespace Media\Factory\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Media\View\Helper\MediaHelper;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class MediaHelperFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $pluginManager)
    {
        // Service locator
        $serviceLocator = $pluginManager->getServiceLocator();

        // Media mapper
        $mediaMapper = $serviceLocator->get('media.mapper.media');

        // Response mapper
        $responseMapper = $serviceLocator->get('media.mapper.response');
        
        // Return helper
        return new MediaHelper($mediaMapper, $responseMapper);
    }
}