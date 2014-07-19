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

        // Authentication service
        $authService = $serviceLocator->get('user.auth.service');
        
        // Media mapper
        $mediaMapper = $serviceLocator->get('media.mapper.media');

        // Comment mapper
        $commentMapper = $serviceLocator->get('media.mapper.comment');
        
        // Vote mapper
        $voteMapper = $serviceLocator->get('media.mapper.vote');
        
        // Module options
        $options = $serviceLocator->get('media.options.module');

        // Return helper
        return new MediaHelper(
            $authService,
            $commentMapper,
            $mediaMapper,
            $voteMapper,
            $options
        );
    }
}