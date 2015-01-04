<?php

namespace Media\Factory\Form;

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
        $options = $serviceLocator->get('media.options.module');
        
        // Get media mapper
        $mediaMapper = $serviceLocator->get('media.mapper.media');
        
        // Get user mapper
        $userMapper = $serviceLocator->get('user.mapper.user');
        
        // Get category mapper
        $categoryMapper = $serviceLocator->get('category.mapper.category');
        
        // Create form
        $form = new UploadForm($mediaMapper, $userMapper, $categoryMapper);
        
        // Set validation group
        $form->setValidationGroup(array(
            'csrf',
            'name',
            'file',
            'category_id',
        ));
        
        // Enable file upload
        $form->enableFileUpload();
        
        // Get hydrator
        $hydratorClass = $options->getMediaHydrator();
        $hydrator      = new $hydratorClass();
        
        // Set hydrator
        $form->setHydrator($hydrator);
        
        // Get input filter
        $inputFilter = new \Media\InputFilter\UploadFilter(
            $mediaMapper,
            $userMapper,
            $categoryMapper
        );
        
        // Set input filter
        $form->setInputFilter($inputFilter);

        // Return form
        return $form;
    }
}