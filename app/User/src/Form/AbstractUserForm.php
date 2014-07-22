<?php

namespace User\Form;

use Zend\Form\Form;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
abstract class AbstractUserForm extends Form
{
    /**
     * @param string $name
     * @param array  $options
     */
    public function __construct($name, array $options = array())
    {
        parent::__construct($name, $options);
        
        // Add elements
        $this
            ->addCsrf()
            ->addId()
            ->addUsername()
            ->addEmail()
            ->addPassword()
            ->addPasswordVerify()
        ;
    }
    
    /**
     * Add the CSRF element.
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
     * Add the identifier element.
     * 
     * @return \User\Form\AbstractForm
     */
    public function addId()
    {
        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));
        
        return $this;
    }
    
    /**
     * Add the username element.
     * 
     * @return \User\Form\AbstractForm
     */
    protected function addUsername()
    {
        $this->add(array(
            'name'    => 'username',
            'type'    => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Username',
            ),
            'attributes' => array(
                'class'       => 'form-control',
                'placeholder' => 'Username',
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add the email address element.
     * 
     * @return \User\Form\AbstractForm
     */
    protected function addEmail()
    {
        $this->add(array(
            'name'    => 'email',
            'type'    => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Email address',
            ),
            'attributes' => array(
                'class'       => 'form-control',
                'placeholder' => 'Email address',
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add the password element.
     * 
     * @return \User\Form\AbstractForm
     */
    protected function addPassword()
    {
        $this->add(array(
            'name'    => 'password',
            'type'    => 'Zend\Form\Element\Password',
            'options' => array(
                'label' => 'Password',
            ),
            'attributes' => array(
                'class'       => 'form-control',
                'placeholder' => 'Password',
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add the password verify element.
     * 
     * @return \User\Form\AbstractForm
     */
    protected function addPasswordVerify()
    {
        $this->add(array(
            'name'    => 'password_verify',
            'type'    => 'Zend\Form\Element\Password',
            'options' => array(
                'label' => 'Password verify',
            ),
            'attributes' => array(
                'class'       => 'form-control',
                'placeholder' => 'Password verify',
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add the submit element.
     * 
     * @param string $label
     * 
     * @return \User\Form\AbstractForm
     */
    public function addSubmit($label = 'Submit')
    {
        $this->add(array(
            'name'    => 'submit',
            'type'    => 'Zend\Form\Element\Submit',
            'options' => array(
                'label' => $label,
            ),
            'attributes' => array(
                'class' => 'btn btn-primary',
                'value' => $label,
            ),
        ));
        
        return $this;
    }
}