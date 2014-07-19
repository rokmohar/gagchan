<?php

namespace User\Form;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <rok.zaloznik@gmail.com>
 */
class LoginForm extends AbstractUserForm
{
    public function __construct($name, array $options = array())
    {
        parent::__construct($name, $options);
        
        // Add elements
        $this
            ->addPasswordVerify()
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
