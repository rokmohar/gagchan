<?php

namespace User;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerPluginProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class Module implements
    AutoloaderProviderInterface,
    BootstrapListenerInterface,
    ConfigProviderInterface,
    ControllerPluginProviderInterface,
    ServiceProviderInterface,
    ViewHelperProviderInterface
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
    public function getControllerPluginConfig()
    {
        return array(
            'factories' => array(
                'user' => 'User\Factory\Controller\Plugin\UserPluginFactory',
            ),
        );
    }
    
    /**
     * {@inheritDoc}
     */
    public function getServiceConfig()
    {
        return array(
            'invokables' => array(
                'user.auth.adapter.db' => 'User\Authentication\Adapter\DbAdapter',
                'user.auth.storage.db' => 'User\Authentication\Storage\DbStorage',
                'user.hydrator.user'   => 'User\Hydrator\UserHydrator',
            ),
            'factories' => array(
                'user.auth.service'  => 'User\Factory\Authentication\AuthenticationServiceFactory',
                'user.form.login'    => 'User\Factory\Form\LoginFormFactory',
                'user.mapper.user'   => 'User\Factory\Mapper\UserMapperFactory',
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
                'user' => 'User\Factory\View\Helper\UserHelperFactory',
            ),
        );
    }
    
    /**
     * {@inheritDoc}
     */
    public function onBootstrap(EventInterface $e)
    {
        $events = $e->getApplication()->getEventManager()->getSharedManager();
        
        $events->attach('ZfcUser\Form\RegisterFilter','init', function($e) {
            $form = $e->getTarget();
            
            $form->get('username')->getValidatorChain()->addValidator(
                new \Zend\Validator\Regex(array(
                    'pattern'  => '/^[a-zA-Z\d\.]*$/',
                    'messages' => array(
                        \Zend\Validator\Regex::NOT_MATCH => 'Value can only contain letters, numbers and dot',
                        \Zend\Validator\Regex::ERROROUS  => 'There was an internal error while validating value',
                    ),
                ))
            );
        });
    }
}
