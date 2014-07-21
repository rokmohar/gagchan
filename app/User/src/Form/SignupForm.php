<?php

namespace User\Form;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class SignupForm extends AbstractUserForm
{
    /**
     * {@inheritDoc}
     */
    public function __construct($name, array $options = array())
    {
        parent::__construct($name, $options);
        
        // Add elements
        $this
            ->addPasswordVerify()
            ->addSubmit('Sign up')
        ;
        
        // Set validation group
        $this->setValidationGroup(array(
            'csrf',
            'username',
            'email',
            'password',
            'password_verify',
        ));
    }
}