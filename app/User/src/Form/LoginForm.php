<?php

namespace User\Form;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class LoginForm extends AbstractUserForm
{
    public function __construct($name, array $options = array())
    {
        parent::__construct($name, $options);
        
        // Add elements
        $this
            ->addSubmit('Log in')
        ;
        
        // Set validation group
        $this->setValidationGroup(array(
            'csrf',
            'email',
            'password',
        ));
    }
}
