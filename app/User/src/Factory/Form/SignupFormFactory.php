<?php

namespace User\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use User\Form\UserForm;

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
        $form = new UserForm($userMapper);
        
        // Set validation group
        $form->setValidationGroup(array(
            'captcha',
            'csrf',
            'email',
            'password',
            'password_verify',
            'username',
        ));
        
        // Get hydrator
        $hydrator = new \User\Hydrator\UserHydrator();
        
        // Set hydrator
        $form->setHydrator($hydrator);
        
        // Get input filter
        $inputFilter = new \User\InputFilter\UserFilter($userMapper);
        
        // Enable validators
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