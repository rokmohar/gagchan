<?php

namespace User\InputFilter;

use Zend\InputFilter\InputFilter;

use User\Mapper\UserMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class UserFilter extends InputFilter
{
    /**
     * @var \User\Mapper\UserMapperInterface
     */
    protected $userMapper;
    
    /**
     * @param \User\Mapper\UserMapperInterface $userMapper
     */
    public function __construct(UserMapperInterface $userMapper)
    {
        // Set user mapper
        $this->userMapper = $userMapper;
        
        // Add filters
        $this
            ->addCsrf()
            ->addUsername()
            ->addEmail()
            ->addPassword()
            ->addPasswordVerify()
        ;
    }
    
    /**
     * Add the CSRF input filter.
     * 
     * @return \User\InputFilter\AbstractFilter
     */
    protected function addCsrf()
    {
        $this->add(array(
            'name'       => 'csrf',
            'required'   => true,
            'validators' => array(
                array(
                    'name' => 'Zend\Validator\Csrf',
                ),
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add the username input filter.
     * 
     * @return \User\InputFilter\AbstractFilter
     */
    protected function addUsername()
    {
        $this->add(array(
            'name'       => 'username',
            'required'   => true,
            'validators' => array(
                array(
                    'name'    => 'User\Validator\Unique',
                    'options' => array(
                        'field'  => 'username',
                        'mapper' => $this->userMapper,
                    ),
                ),
                array(
                    'name'    => 'Zend\Validator\Regex',
                    'options' => array(
                        'pattern'  => '/^[a-zA-Z\d\.\_]*$/',
                        'messages' => array(
                            \Zend\Validator\Regex::NOT_MATCH => 'Value can only contain letters, numbers, dot and underscore.',
                        ),
                    ),
                ),
                array(
                    'name'    => 'Zend\Validator\StringLength',
                    'options' => array(
                        'min' => 6,
                        'max' => 255,
                    ),
                ),
            ),
            'filters' => array(
                array('name' => 'Zend\Filter\StringTrim'),
                array('name' => 'Zend\Filter\StripTags'),
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add the email address input filter.
     * 
     * @return \User\InputFilter\AbstractFilter
     */
    protected function addEmail()
    {
        $this->add(array(
            'name'       => 'email',
            'required'   => true,
            'validators' => array(
                array(
                    'name'    => 'User\Validator\Unique',
                    'options' => array(
                        'field'  => 'email',
                        'mapper' => $this->userMapper,
                    ),
                ),
                array(
                    'name'    => 'Zend\Validator\StringLength',
                    'options' => array(
                        //'min' => 6,
                        'max' => 255,
                    ),
                ),
                array(
                    'name' => 'Zend\Validator\EmailAddress',
                ),
            ),
            'filters' => array(
                array('name' => 'Zend\Filter\StringTrim'),
                array('name' => 'Zend\Filter\StripTags'),
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add the password input filter.
     * 
     * @return \User\InputFilter\AbstractFilter
     */
    protected function addPassword()
    {
        $this->add(array(
            'name'       => 'password',
            'required'   => true,
            'validators' => array(
                array(
                    'name'    => 'Zend\Validator\StringLength',
                    'options' => array(
                        'min' => 6,
                        'max' => 255,
                    ),
                ),
            ),
            'filters' => array(
                array('name' => 'Zend\Filter\StringTrim'),
                array('name' => 'Zend\Filter\StripTags'),
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add the password verify input filter.
     * 
     * @return \User\InputFilter\AbstractFilter
     */
    protected function addPasswordVerify()
    {
        $this->add(array(
            'name'       => 'password_verify',
            'required'   => true,
            'validators' => array(
                array(
                    'name'    => 'Zend\Validator\Identical',
                    'options' => array(
                        'token' => 'password',
                    ),
                ),
            ),
            'filters' => array(
                array('name' => 'Zend\Filter\StringTrim'),
                array('name' => 'Zend\Filter\StripTags'),
            ),
        ));
        
        return $this;
    }
}