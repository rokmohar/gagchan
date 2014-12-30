<?php

namespace User\Factory\Form\Confirmation;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use User\Form\Confirmation\DefaultConfirmationForm;
use User\Hydrator\ConfirmationHydrator;
use User\InputFilter\Confirmation\DefaultConfirmationFilter;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class RequestFormFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Get confirmation mapper
        $confirmationMapper = $serviceLocator->get('user.mapper.confirmation');
        
        // Get user mapper
        $userMapper = $serviceLocator->get('user.mapper.user');
        
        // Create form
        $form = new DefaultConfirmationForm($confirmationMapper, $userMapper);
        
        // Create hydrator
        $form->setHydrator(new ConfirmationHydrator());
        
        // Create input filter
        $form->setInputFilter(new DefaultConfirmationFilter($confirmationMapper, $userMapper));
        
        // Return form
        return $form;
    }
}