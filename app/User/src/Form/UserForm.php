<?php

namespace User\Form;

use Zend\Form\Form;

use User\Mapper\UserMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class UserForm extends Form
{
    /**
     * @var \User\Mapper\UserMapperInterface
     */
    protected $userMapper;
    
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
            ->addState()
            ->addCaptcha()
            ->addSubmit()
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
     * @return \User\Form\UserForm
     */
    protected function addId()
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
     * @return \User\Form\UserForm
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
     * @return \User\Form\UserForm
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
     * @return \User\Form\UserForm
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
     * Add the state element.
     * 
     * @return \User\Form\UserForm
     */
    protected function addState()
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
        // Check if user mapper is empty
        if ($this->userMapper === null) {
            // Set the user mapper
            $this->setUserMapper($this->getOption('user_mapper'));
        }
        
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