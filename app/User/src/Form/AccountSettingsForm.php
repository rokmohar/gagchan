<?php

namespace User\Form;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class AccountSettingsForm extends AbstractUserForm
{
    public function __construct($name, array $options = array())
    {
        parent::__construct($name, $options);
        
        // Add elements
        $this
            ->addSubmit('Save')
        ;
        
        // Set validation group
        $this->setValidationGroup(array(
            'csrf',
            'username',
            'email',
        ));
    }
}
