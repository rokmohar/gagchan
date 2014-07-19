<?php

namespace User\Form;

use Zend\Form\Form;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <rok.zaloznik@gmail.com>
 */
abstract class AbstractUserForm extends Form
{
    /**
     * @param String $name
     * @param Array  $options
     */
    public function __construct($name, array $options = array())
    {
        parent::__construct($name, $options);
        
        // Add elements
        $this
            ->addCsrf()
            ->addUsername()
            ->addEmail()
            ->addPassword()
            ->addPasswordVerify()
            ->addSubmit()
        ;
    }
    
    /**
     * Add the CSRF form element.
     * 
     * @return \User\Form\AbstractForm
     */
    public function addCsrf()
    {
        $this->add(array(
            'name' => 'csrf',
            'type' => 'Zend\Form\Element\Csrf',
        ));
        
        return $this;
    }
    
    /**
     * Add the username form element.
     * 
     * @return \User\Form\AbstractForm
     */
    protected function addUsername()
    {
        $this->add(array(
            'name'    => 'username',
            'options' => array(
                'label' => 'Username',
            ),
            'attributes' => array(
                'type'        => 'text',
                'class'       => 'form-control',
                'placeholder' => 'Username',
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add the email address form element.
     * 
     * @return \User\Form\AbstractForm
     */
    protected function addEmail()
    {
        $this->add(array(
            'name'    => 'email',
            'options' => array(
                'label' => 'Email address',
            ),
            'attributes' => array(
                'type'        => 'text',
                'class'       => 'form-control',
                'placeholder' => 'Email address',
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add the password form element.
     * 
     * @return \User\Form\AbstractForm
     */
    protected function addPassword()
    {
        $this->add(array(
            'name'    => 'password',
            'options' => array(
                'label' => 'Password',
            ),
            'attributes' => array(
                'type'        => 'password',
                'class'       => 'form-control',
                'placeholder' => 'Password',
            ),
        ));
        
        return $this;
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
    
    /**
     * Add the submit form element.
     * 
     * @return \User\Form\AbstractForm
     */
    public function addSubmit()
    {
        $this->add(array(
            'name'    => 'submit',
            'options' => array(
                'label' => 'Log in',
            ),
            'attributes' => array(
                'type'  => 'submit',
                'class' => 'btn btn-primary',
                'value' => 'Log in',
            ),
        ));
        
        return $this;
    }
}