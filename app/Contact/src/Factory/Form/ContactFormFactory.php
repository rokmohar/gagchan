<?php

namespace Contact\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Contact\Form\ContactForm;

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
        
        // Set hydrator
        $form->setHydrator(new \Zend\Stdlib\Hydrator\ClassMethods());
        
        // Set filter 
        $form->setInputFilter(new \Contact\InputFilter\ContactFilter());
        
        // Return form
        return $form;
    }
}