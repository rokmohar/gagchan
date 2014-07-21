<?php

namespace Contact\Factory\Form;

use Contact\Form\ContactForm;
use Contact\InputFilter\ContactFilter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class ContactFormFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */    
    public function createService(ServiceLocatorInterface $services)
    {
        // Create form
        $form = new ContactForm('contact');
        
        // Set input filter 
        $form->setInputFilter(new ContactFilter());
        
        // Return form
        return $form;
    }
}