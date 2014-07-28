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
        
        // Get vote mapper
        $voteMapper = $serviceLocator->get('media.mapper.vote');
        
        // Get media mapper
        $mediaMapper = $serviceLocator->get('media.mapper.media');
        
        // Get user mapper
        $userMapper = $serviceLocator->get('user.mapper.user');
        
        // Create form
        $form = new VoteForm($voteMapper, $mediaMapper, $userMapper);
        
        // Get hydrator
        $hydratorClass = $options->getVoteHydrator();
        $hydrator      = new $hydratorClass();
        
        // Set hydrator
        $form->setHydrator($hydrator);
        
        // Get input filter
        $inputFilter = new VoteFilter($voteMapper, $mediaMapper, $userMapper);
        
        // Set input filter
        $form->setInputFilter($inputFilter);

        // Return form
        return $form;
    }
}