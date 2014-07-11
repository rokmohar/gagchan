<?php

namespace Media\Factory\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Media\View\Helper\CommentHelper;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class CommentHelperFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $pluginManager)
    {
        // Service locator
        $serviceLocator = $pluginManager->getServiceLocator();

        // Comment mapper
        $commentMapper = $serviceLocator->get('media.mapper.comment');

        // Create and return helper
        return new CommentHelper($commentMapper);
    }
}