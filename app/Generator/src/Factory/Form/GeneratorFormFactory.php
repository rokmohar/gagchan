<?php

namespace Generator\Factory\Form;

use Generator\Form\GeneratorForm;
use Generator\InputFilter\GeneratorFilter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class GeneratorFormFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */    
    public function createService(ServiceLocatorInterface $services)
    {
        // Create form
        $form = new GeneratorForm('contact');
        
        // Set input filter 
        $form->setInputFilter(new GeneratorFilter());
        
        // Return form
        return $form;
    }
}