<?php

namespace Media;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ServiceProviderInterface
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
                'media.form.copy'               => 'Media\Factory\Form\CopyFormFactory',
                'media.form.upload'             => 'Media\Factory\Form\UploadFormFactory',
                'media.form.vote'               => 'Media\Factory\Form\VoteFormFactory',
                'media.mapper.comment'          => 'Media\Factory\Mapper\CommentMapperFactory',
                'media.mapper.media'            => 'Media\Factory\Mapper\MediaMapperFactory',
                'media.mapper.vote'             => 'Media\Factory\Mapper\VoteMapperFactory',
                'media.options.module'          => 'Media\Factory\Options\ModuleOptionsFactory',
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
                'comment'  => 'Media\Factory\View\Helper\CommentHelperFactory',
                'media'    => 'Media\Factory\View\Helper\MediaHelperFactory',
                'category' => 'Category\Factory\View\Helper\CategoryHelperFactory',
            ),
        );
    }
}
