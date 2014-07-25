<?php

namespace User;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
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
            ),
            'factories' => array(
                'user.auth.service'        => 'User\Factory\Authentication\AuthenticationServiceFactory',
                'user.form.account'        => 'User\Factory\Form\AccountFormFactory',
                'user.form.login'          => 'User\Factory\Form\LoginFormFactory',
                'user.form.password'       => 'User\Factory\Form\PasswordFormFactory',
                'user.form.recover'        => 'User\Factory\Form\RecoverFormFactory',
                'user.form.reset'          => 'User\Factory\Form\ResetFormFactory',
                'user.form.signup'         => 'User\Factory\Form\SignupFormFactory',
                'user.mailer.amazon'       => 'User\Factory\Mailer\AmazonMailerFactory',
                'user.mapper.confirmation' => 'User\Factory\Mapper\ConfirmationMapperFactory',
                'user.mapper.recover'      => 'User\Factory\Mapper\RecoverMapperFactory',
                'user.mapper.user'         => 'User\Factory\Mapper\UserMapperFactory',
                'user.options.module'      => 'User\Factory\Options\ModuleOptionsFactory',
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
}
