<?php

namespace User\Form;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <rok.zaloznik@gmail.com>
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
        ;
        
        // Set validation group
        $this->setValidationGroup(array(
            'csrf',
            'password',
            'password_verify',
        ));
    }
    
    /**
     * Add the password verify form element.
     * 
     * @return \User\Form\AbstractForm
     */
    protected function addPasswordVerify()
    {
        $this->add(array(
            'name'    => 'password_verify',
            'options' => array(
                'label' => 'Password verify',
            ),
            'attributes' => array(
                'type'        => 'password',
                'class'       => 'form-control',
                'placeholder' => 'Password verify',
            ),
        ));
        
        return $this;
    }
}
