<?php

namespace Media\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Media\Form\CommentForm;
use Media\InputFilter\CommentFilter;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class CommentFormFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Module options
        $options = $serviceLocator->get('media.options.module');
        
        // Get comment mapper
        $commentMapper = $serviceLocator->get('media.mapper.comment');
        
        // Get media mapper
        $mediaMapper = $serviceLocator->get('media.mapper.media');
        
        // Get user mapper
        $userMapper = $serviceLocator->get('user.mapper.user');
        
        // Create form
        $form = new CommentForm($commentMapper, $mediaMapper, $userMapper);
        
        // Get hydrator
        $hydratorClass = $options->getCommentHydrator();
        $hydrator      = new $hydratorClass();
        
        // Set hydrator
        $form->setHydrator($hydrator);
        
        // Get input filter
        $inputFilter = new CommentFilter($commentMapper, $mediaMapper, $userMapper);
        
        // Set input filter
        $form->setInputFilter($inputFilter);

        // Return form
        return $form;
    }
}