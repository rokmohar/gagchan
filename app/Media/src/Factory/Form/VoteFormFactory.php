<?php

namespace Media\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Media\Form\VoteForm;
use Media\InputFilter\VoteFilter;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class VoteFormFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Module options
        $options = $serviceLocator->get('media.options.module');
        
        // Hydrator
        $hydratorClass = $options->getVoteHydrator();
        $hydrator      = new $hydratorClass();
        
        // Create form
        $form = new VoteForm('vote');
        
        // Set hydrator
        $form->setHydrator($hydrator);
        
        // Set input filter
        $form->setInputFilter(new VoteFilter());

        // Return form
        return $form;
    }
}