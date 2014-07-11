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
        // Create form
        $form = new CommentForm('comment');
        
        // Set input filter
        $form->setInputFilter(new CommentFilter());

        // Return form
        return $form;
    }
}