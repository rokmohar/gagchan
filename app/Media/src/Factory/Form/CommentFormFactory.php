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
        
        // Get media mapper
        $mediaMapper = $serviceLocator->get('media.mapper.media');
        
        // Get user mapper
        $userMapper = $serviceLocator->get('user.mapper.user');
        
        // Create form
        $form = new CommentForm('comment', array(
            'media_mapper' => $mediaMapper,
            'user_mapper'  => $userMapper,
        ));
        
        // Get hydrator
        $hydratorClass = $options->getCommentHydrator();
        $hydrator      = new $hydratorClass();
        
        // Set hydrator
        $form->setHydrator($hydrator);
        
        // Set input filter
        $form->setInputFilter(new CommentFilter(array(
            'media_mapper' => $mediaMapper,
            'user_mapper'  => $userMapper,
        )));

        // Return form
        return $form;
    }
}