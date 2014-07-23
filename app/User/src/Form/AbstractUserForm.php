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
            ->addCaptcha()
        ;
        
        //$this->add(new \Zend\Form\Element\Captcha(), array('name' => 'captcha'));
    }
    
    /**
     * Add CSRF element.
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
     * Add identifier element.
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
     * Add username element.
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
     * Add email address element.
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
     * Add password element.
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
     * Add password verify element.
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
     * Add captcha element.
     * 
     * @return \User\Form\AbstractUserForm
     */
    public function addCaptcha()
    {
        $this->add(array(
            'name'    => 'captcha',
            'type'    => 'Zend\Form\Element\Captcha',
            'options' => array(
                'label'   => 'Please type the following text',
                'captcha' => array(
                    'class'   => 'Zend\Captcha\ReCaptcha',
                    'options' => array(
                        'pubkey'  => '6LdWDvcSAAAAAFjb7VFZFR47NMZYQL7t2saq28ua',
                        'privkey' => '6LdWDvcSAAAAAAjhm56hU22-FmpXI1LXGveN0yo_',
                        'theme'   => 'white',
                    ),
                ),
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add submit element.
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