<?php

namespace Media\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

//use Media\Entity\MediaEntity;
use Media\Form\MediaForm;
use Media\Hydrator\MediaHydrator;
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
        // Category mapper
        $categoryMapper = $serviceLocator->get('media.mapper.category');
        
        // Create form
        $form = new MediaForm('media', $categoryMapper);
        
        // Set hydrator
        $form->setHydrator(new MediaHydrator());
        //$form->bind(new MediaEntity());
        
        // Set input filter
        $form->setInputFilter(new MediaFilter());

        // Return form
        return $form;
    }
}