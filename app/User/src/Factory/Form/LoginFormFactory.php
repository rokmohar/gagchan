<?php

namespace User\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use User\Form\DefaultUserForm;
use User\Hydrator\UserHydrator;
use User\InputFilter\DefaultUserFilter;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class LoginFormFactory implements FactoryInterface
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
            'email',
            'password',
        ));
        
        // Create hydrator
        $form->setHydrator(new UserHydrator());
        
        // Create input filter
        $form->setInputFilter(new DefaultUserFilter($userMapper));
        
        // Return form
        return $form;
    }
}