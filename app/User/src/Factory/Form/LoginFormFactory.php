<?php

namespace User\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use User\Form\LoginForm;

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
        // Create form
        $form = new LoginForm('login', array());
        
        // Set hydrator
        $form->setHydrator(new \User\Hydrator\UserHydrator());
        
        // Set filter
        $form->setInputFilter(new \User\InputFilter\UserFilter());
        
        // Return form
        return $form;
    }
}