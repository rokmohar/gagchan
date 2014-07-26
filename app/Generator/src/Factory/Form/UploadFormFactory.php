<?php

namespace Generator\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Media\Form\UploadForm;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class UploadFormFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Module options
        //$options = $serviceLocator->get('media.options.module');
        
        // Create form
        $form = new UploadForm('media', array());
        
        // Set validation group
        $form->setValidationGroup(array(
            'csrf',
            'name',
            'category_id',
        ));
        
        // Enable file upload
        $form->enableFileUpload();
        
        // Get hydrator
        //$hydratorClass = $options->getMediaHydrator();
        //$hydrator      = new $hydratorClass();
        
        // Set hydrator
        //$form->setHydrator($hydrator);
        
        // Get input filter
        $inputFilter = new \Media\InputFilter\UploadFilter();
        
        // Set input filter
        $form->setInputFilter($inputFilter);

        // Return form
        return $form;
    }
}