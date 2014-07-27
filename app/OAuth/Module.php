<?php

namespace OAuth;

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
            'invokables' => array(
                'oauth.auth.adapter.oauth' => 'OAuth\Authentication\Adapter\OAuthAdapter',
            ),
            'factories' => array(
                'oauth.hybridauth'     => 'OAuth\Factory\HybridAuthFactory',
                'oauth.manager.oauth'  => 'OAuth\Factory\Manager\OAuthManagerFactory',
                'oauth.mapper.oauth'   => 'OAuth\Factory\Mapper\OAuthMapperFactory',
                'oauth.options.module' => 'OAuth\Factory\Options\ModuleOptionsFactory'
            ),
        );
    }
    
}
