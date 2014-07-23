<?php

namespace Generator\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Generator\Form\GeneratorForm;
use Generator\InputFilter\GeneratorFilter;

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
        
        // Set filter 
        $form->setInputFilter(new GeneratorFilter());
        
        // Return form
        return $form;
    }
}