<?php

namespace User\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use User\Form\UserForm;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class PasswordFormFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Get user mapper
        $userMapper = $serviceLocator->get('user.mapper.user');
        
        // Create form
        $form = new UserForm('password_settings', array(
            'user_mapper' => $userMapper,
        ));
        
        // Set validation group
        $form->setValidationGroup(array(
            'csrf',
            'password',
            'password_verify',
        ));
        
        // Get hydrator
        $hydrator = new \User\Hydrator\UserHydrator();
        
        // Set hydrator
        $form->setHydrator($hydrator);
        
        // Get input filter
        $inputFilter = new \User\InputFilter\UserFilter(array(
            'user_mapper' => $userMapper,
        ));
        
        // Enable string length for the password
        $inputFilter->enablePasswordStringLength();
        
        // Set input filter
        $form->setInputFilter($inputFilter);
        
        // Return form
        return $form;
    }
}