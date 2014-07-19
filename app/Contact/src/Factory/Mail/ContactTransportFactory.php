<?php

namespace Contact\Factory\Mail;

use Zend\Mail\Transport;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <rok.zaloznik@gmail.com>
 */
class ContactTransportFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Module options
        $options = $serviceLocator->get('contact.options.module');
        
        // Transport
        $transport = $options->getTransport();
        
        switch ($transport['class']) {
            case 'Zend\Mail\Transport\Sendmail':
            case 'Sendmail':
            case 'sendmail';
                return new Transport\Sendmail();
                
            case 'Zend\Mail\Transport\Smtp';
            case 'Smtp';
            case 'smtp';
                return new Transport\Smtp(
                    new Transport\SmtpOptions($transport['options'])
                );
                
            case 'Zend\Mail\Transport\File';
            case 'File';
            case 'file';
                return new Transport\File(
                    new Transport\FileOptions($transport['options'])
                );
        }

        throw new \DomainException(sprintf(
            'Unknown mail transport type provided ("%s")',
            $transport['class']
        ));
    }
}