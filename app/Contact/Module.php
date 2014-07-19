<?php

namespace Contact;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <rok.zaloznik@gmail.com>
 */
class Module implements
    AutoloaderProviderInterface,
    ServiceProviderInterface
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
                'contact.form.contact'   => 'Contact\Factory\Form\ContactFormFactory',
                'contact.mail.message'   => 'Contact\Factory\Mail\ContactMessageFactory',
                'contact.mail.transport' => 'Contact\Factory\Mail\ContactTransportFactory',
            ),
        );
    }
}
