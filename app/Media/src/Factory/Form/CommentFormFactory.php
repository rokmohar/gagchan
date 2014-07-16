<?php

namespace Media\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Media\Form\CommentForm;
use Media\InputFilter\CommentFilter;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
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
        
        // Hydrator
        $hydratorClass = $options->getCommentHydrator();
        $hydrator      = new $hydratorClass();
        
        // Create form
        $form = new CommentForm('comment');
        
        // Set hydrator
        $form->setHydrator($hydrator);
        
        // Set input filter
        $form->setInputFilter(new CommentFilter());

        // Return form
        return $form;
    }
}