<?php

namespace Media\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Media\Form\MediaForm;
use Media\InputFilter\MediaFilter;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class MediaFormFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Module options
        $options = $serviceLocator->get('media.options.module');
        
        // Hydrator
        $hydratorClass = $options->getMediaHydrator();
        $hydrator      = new $hydratorClass();
        
        // Category mapper
        $categoryMapper = $serviceLocator->get('category.mapper.category');
        
        // Create form
        $form = new MediaForm('media', $categoryMapper);
        
        // Set hydrator
        $form->setHydrator($hydrator);
        
        // Set input filter
        $form->setInputFilter(new MediaFilter());

        // Return form
        return $form;
    }
}