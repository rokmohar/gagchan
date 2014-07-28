<?php

namespace Generator;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class Module implements
    AutoloaderProviderInterface,
    ServiceProviderInterface,
    ViewHelperProviderInterface
{
    /**
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    /**
     * @return array
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
     * @return array
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'generator.form.generator'   => 'Generator\Factory\Form\GeneratorFormFactory',
                'generator.form.preview'     => 'Generator\Factory\Form\PreviewFormFactory',
                'generator.form.publish'     => 'Generator\Factory\Form\PublishFormFactory',
                'generator.mapper.prototype' => 'Generator\Factory\Mapper\PrototypeMapperFactory',
                'generator.util.module'      => 'Generator\Factory\Util\MemeGeneratorFactory',
            ),
        );
    }

    /**
     * @return array
     */
    public function getViewHelperConfig()
    {
        
        return array(
            'factories' => array(
                'prototype' => 'Generator\Factory\View\Helper\PrototypeHelperFactory',
            ),
        );
    }

}
