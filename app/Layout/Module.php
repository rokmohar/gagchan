<?php

namespace Layout;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class Module implements
    AutoloaderProviderInterface,
    BootstrapListenerInterface,
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
                'layout.options' => 'Layout\Factory\Options\LayoutOptionsFactory',
                'layout.service' => 'Layout\Factory\Service\LayoutServiceFactory',
            ),
        );
    }
    
    /**
     * {@inheritDoc}
     */
    public function onBootstrap(EventInterface $e)
    {
        // Ignore if console request
        if ($e->getRequest() instanceof \Zend\Console\Request) return;
        
        // Get application
        $app = $e->getApplication();
        
        // Get service and event manager
        $sm = $app->getServiceManager();
        $em = $app->getEventManager();
        
        // Attach layout service
        $em->attach($sm->get('layout.service'));
    }
}