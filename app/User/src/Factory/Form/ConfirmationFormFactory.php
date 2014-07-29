<?php

namespace User\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use User\Form\ConfirmationForm;
use User\Hydrator\ConfirmationHydrator;
use User\InputFilter\ConfirmationFilter;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class ConfirmationFormFactory implements FactoryInterface
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
        $form = new ConfirmationForm($confirmationMapper, $userMapper);
        
        // Get hydrator
        $hydrator = new ConfirmationHydrator();
        
        // Set hydrator
        $form->setHydrator($hydrator);
        
        // Get input filter
        $inputFilter = new ConfirmationFilter($confirmationMapper, $userMapper);
        
        // Set input filter
        $form->setInputFilter($inputFilter);
        
        // Return form
        return $form;
    }
}