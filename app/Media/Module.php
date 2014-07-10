<?php

namespace Media;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ServiceProviderInterface
{
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
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'media.form.media'              => 'Media\Factory\Form\MediaFormFactory',
                'media.mapper.media'            => 'Media\Factory\Mapper\MediaMapperFactory',
                'media.service.bucket_manager'  => 'Media\Factory\Service\BucketManagerFactory',
                'media.service.media_manager'   => 'Media\Factory\Service\MediaManagerFactory',
                'media.storage.storage_manager' => 'Media\Factory\Storage\StorageManagerFactory',
            ),
        );
    }
}
