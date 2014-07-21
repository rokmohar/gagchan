<?php

namespace User\Form;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class PasswordSettingsForm extends AbstractUserForm
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
            ->addSubmit('Save')
        ;
        
        // Set validation group
        $this->setValidationGroup(array(
            'csrf',
            'password',
            'password_verify',
        ));
    }
}
