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
                'generator.form.upload'      => 'Generator\Factory\Form\UploadFormFactory',
                'generator.mapper.prototype' => 'Generator\Factory\Mapper\PrototypeMapperFactory',
                'generator.options.module'   => 'Generator\Factory\Options\ModuleOptionsFactory',
                'generator.util.module'      => 'Generator\Factory\Util\MemeGeneratorFactory',
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
                'generator' => 'Generator\Factory\View\Helper\GeneratorHelperFactory',
                'publish'    => 'Media\Factory\View\Helper\MediaHelperFactory',                
            ),
        );
    }    
}
