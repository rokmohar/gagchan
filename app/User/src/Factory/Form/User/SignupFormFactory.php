<?php

namespace User\Factory\Form\User;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use User\Form\User\DefaultUserForm;
use User\Hydrator\UserHydrator;
use User\InputFilter\User\DefaultUserFilter;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class SignupFormFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Get user mapper
        $userMapper = $serviceLocator->get('user.mapper.user');
        
        // Create form
        $form = new DefaultUserForm($userMapper);
        
        // Set validation group
        $form->setValidationGroup(array(
            'csrf',
            'username',
            'email',
            'password',
            'password_verify',
            'captcha',
        ));
        
        // Create hydrator
        $form->setHydrator(new UserHydrator());
        
        // Create input filter
        $inputFilter = new DefaultUserFilter($userMapper);
        
        $inputFilter
            ->enableEmailNoRecordExists()
            ->enablePasswordStringLength()
            ->enableUsernameNoRecordExists()
        ;
        
        // Set input filter
        $form->setInputFilter($inputFilter);
        
        // Return form
        return $form;
    }
}