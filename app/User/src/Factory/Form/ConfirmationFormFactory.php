<?php

namespace User\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use User\Form\Confirmation\CreateConfirmationForm;
use User\Hydrator\ConfirmationHydrator;
use User\InputFilter\Confirmation\CreateConfirmationFilter;

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
        $form = new CreateConfirmationForm($confirmationMapper, $userMapper);
        
        // Create hydrator
        $hydrator = new ConfirmationHydrator();
        
        // Set hydrator
        $form->setHydrator($hydrator);
        
        // Create input filter
        $inputFilter = new CreateConfirmationFilter($confirmationMapper, $userMapper);
        
        // Set input filter
        $form->setInputFilter($inputFilter);
        
        // Return form
        return $form;
    }
}