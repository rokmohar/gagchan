<?php

namespace User\Form;

use Zend\Form\Form;

use User\Mapper\UserMapperAwareInterface;
use User\Mapper\UserMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class UserForm extends Form implements UserMapperAwareInterface
{
    /**
     * @var \User\Mapper\UserMapperInterface
     */
    protected $userMapper;
    
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
     * @return \User\Form\UserForm
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
     * @return \User\Form\UserForm
     */
    public function addUsername()
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
     * @return \User\Form\UserForm
     */
    public function addEmail()
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
     * @return \User\Form\UserForm
     */
    public function addPassword()
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
     * @return \User\Form\UserForm
     */
    public function addPasswordVerify()
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
     * Add the state element.
     * 
     * @return \User\Form\UserForm
     */
    public function addState()
    {
        $this->add(array(
            'name'    => 'state',
            'type'    => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'State',
            ),
            'attributes' => array(
                'class'       => 'form-control',
                'placeholder' => 'State',
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add the captcha element.
     * 
     * @return \User\Form\UserForm
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
     * Add the submit element.
     * 
     * @return \User\Form\UserForm
     */
    public function addSubmit()
    {
        $this->add(array(
            'name'    => 'submit',
            'type'    => 'Zend\Form\Element\Submit',
            'options' => array(
                'label' => 'Submit',
            ),
            'attributes' => array(
                'class' => 'btn btn-primary',
                'value' => 'Submit',
            ),
        ));
        
        return $this;
    }
    
    /**
     * Return the user mapper.
     * 
     * @return \User\Mapper\UserMapperInterface
     */
    public function getUserMapper()
    {
        return $this->userMapper;
    }
    
    /**
     * Set the user mapper.
     * 
     * @param \User\Mapper\UserMapperInterface $userMapper
     */
    public function setUserMapper(UserMapperInterface $userMapper)
    {
        $this->userMapper = $userMapper;
        
        return $this;
    }
}