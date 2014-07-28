<?php

namespace Generator\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Generator\Form\GeneratorForm;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class GeneratorFormFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */    
    public function createService(ServiceLocatorInterface $erviceLocator)
    {
        // Create form
        $form = new GeneratorForm('contact');
        
        // Set filter 
        $form->setInputFilter(new \Generator\InputFilter\GeneratorFilter());
        
        // Return form
        return $form;
    }
}