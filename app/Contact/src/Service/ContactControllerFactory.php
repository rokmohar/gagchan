<?php

namespace Contact\Service;

use Contact\Controller\ContactController;
use Zend\Mail\Message;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <rok.zaloznik@gmail.com>
 */
class ContactControllerFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $services)
    {
        $serviceLocator = $services->getServiceLocator();
        
        // Create form
        $form = $serviceLocator->get('ContactForm');
        
        // Create message
        $message = $serviceLocator->get('ContactMailMessage');
        
        // Create transport
        $transport = $serviceLocator->get('ContactMailTransport');

        // Create controller
        $controller = new ContactController();
        
        // Set form
        $controller->setContactForm($form);
        
        // Set message
        $controller->setMessage($message);
        
        // Set mail transport
        $controller->setMailTransport($transport);
        
        // Return controller
        return $controller;
    }
}