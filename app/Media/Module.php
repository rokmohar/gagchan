<?php

namespace Media;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ServiceProviderInterface,
    ViewHelperProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src',
                ),
            ),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    /**
     * {@inheritDoc}
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'media.form.comment'            => 'Media\Factory\Form\CommentFormFactory',
                'media.form.media'              => 'Media\Factory\Form\MediaFormFactory',
                'media.mapper.category'         => 'Media\Factory\Mapper\CategoryMapperFactory',
                'media.mapper.comment'          => 'Media\Factory\Mapper\CommentMapperFactory',
                'media.mapper.media'            => 'Media\Factory\Mapper\MediaMapperFactory',
                'media.service.media_manager'   => 'Media\Factory\Service\MediaManagerFactory',
                'media.storage.storage_manager' => 'Media\Factory\Storage\StorageManagerFactory',
            ),
        );
    }
    
    /**
     * {@inheritDoc}
     */
    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'category' => 'Media\Factory\View\Helper\CategoryHelperFactory',
                'comment'  => 'Media\Factory\View\Helper\CommentHelperFactory',
                'media'    => 'Media\Factory\View\Helper\MediaHelperFactory',
            ),
        );
    }
}
