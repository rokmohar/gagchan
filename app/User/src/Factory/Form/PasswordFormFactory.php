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
        $form = new UserForm('password');
        
        // Get hydrator
        $hydrator = new \User\Hydrator\UserHydrator();
        
        // Set hydrator
        $form->setHydrator($hydrator);
        
        // Get input filter
        $inputFilter = new \User\InputFilter\UserFilter();
        
        // Set user mapper
        $inputFilter->setUserMapper($userMapper);
        
        // Add filters
        $inputFilter
            ->addCsrf()
            ->addPassword()
            ->addPasswordVerify()
        ;
        
        // Enable validators
        $inputFilter
            ->enablePasswordStringLength()
        ;
        
        // Set input filter
        $form->setInputFilter($inputFilter);
        
        // Set user mapper
        $form->setUserMapper($userMapper);
        
        // Add elements
        $form
            ->addCsrf()
            ->addPassword()
            ->addPasswordVerify()
            ->addSubmit()
        ;
        
        // Return form
        return $form;
    }
}