<?php

namespace Generator\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Generator\Form\PublishForm;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class PublishFormFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Get media mapper
        $mediaMapper = $serviceLocator->get('media.mapper.media');
        
        // Get user mapper
        $userMapper = $serviceLocator->get('user.mapper.user');
        
        // Get category mapper
        $categoryMapper = $serviceLocator->get('category.mapper.category');
        
        // Create form
        $form = new PublishForm($mediaMapper, $userMapper, $categoryMapper);
        
        // Set validation group
        $form->setValidationGroup(array(
            'csrf',
            'name',
            'category_id',
        ));
        
        // Get hydrator
        $hydrator = new \Media\Hydrator\MediaHydrator();
        
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
