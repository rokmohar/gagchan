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
                'user.auth.adapter.db'      => 'User\Authentication\Adapter\DbAdapter',
                'user.auth.storage.db'      => 'User\Authentication\Storage\DbStorage',
                'user.manager.confirmation' => 'User\Manager\ConfirmationManager',
                'user.manager.recover'      => 'User\Manager\RecoverManager',
                'user.manager.user'         => 'User\Manager\UserManager',
            ),
            'factories' => array(
                'user.auth.service'        => 'User\Factory\Authentication\AuthenticationServiceFactory',
                'user.form.email'          => 'User\Factory\Form\EmailFormFactory',
                'user.form.login'          => 'User\Factory\Form\LoginFormFactory',
                'user.form.password'       => 'User\Factory\Form\PasswordFormFactory',
                'user.form.settings'       => 'User\Factory\Form\SettingsFormFactory',
                'user.form.signup'         => 'User\Factory\Form\SignupFormFactory',
                'user.form.username'       => 'User\Factory\Form\UsernameFormFactory',
                'user.mailer.amazon'       => 'User\Factory\Mailer\AmazonMailerFactory',
                'user.mapper.confirmation' => 'User\Factory\Mapper\ConfirmationMapperFactory',
                'user.mapper.recover'      => 'User\Factory\Mapper\RecoverMapperFactory',
                'user.mapper.user'         => 'User\Factory\Mapper\UserMapperFactory',
                'user.navigation'          => 'User\Factory\Navigation\Service\UserNavigationFactory',
                'user.options.user'        => 'User\Factory\Options\UserOptionsFactory',
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
