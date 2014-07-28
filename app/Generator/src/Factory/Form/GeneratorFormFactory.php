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
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Create form
        $form = new GeneratorForm();
        
        // Get input filter
        $inputFilter = new \Generator\InputFilter\GeneratorFilter();
        
        // Set input filter 
        $form->setInputFilter($inputFilter);
        
        // Return form
        return $form;
    }
}