<?php

namespace Contact\Factory\Mailer;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Renderer\PhpRenderer;

use Contact\Mailer\AmazonMailer;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class AmazonMailerFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Get AWS
        $aws = $serviceLocator->get('aws');
        
        // Get options
        $options = $serviceLocator->get('core.options.module');
        
        // Get PHP renderer
        $renderer = new PhpRenderer();
        
        return new AmazonMailer($aws, $options, $renderer);
    }
}