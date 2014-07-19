<?php

namespace Contact\Service;

use Traversable;
use Contact\Form\ContactForm;
use Contact\InputFilter\ContactFilter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\ArrayUtils;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <rok.zaloznik@gmail.com>
 */
class ContactFormFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */    
    public function createService(ServiceLocatorInterface $services)
    {
        $config = $services->get('config');
        if ($config instanceof Traversable) {
            $config = ArrayUtils::iteratorToArray($config);
        }
        $name = $config['contact']['form']['name'];
        $captcha = $services->get('ContactCaptcha');
                
        // Create form
        $form = new ContactForm($name, $captcha);
        
        // Set input filter 
        $form->setInputFilter(new ContactFilter());
        
        // Return form
        return $form;
    }
}