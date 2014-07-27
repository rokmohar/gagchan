<?php

namespace User\InputFilter;

use Zend\InputFilter\InputFilter;

use User\Mapper\UserMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class UserFilter extends InputFilter implements UserFilterInterface
{
    /**
     * @var \User\Mapper\UserMapperInterface
     */
    protected $userMapper;
    
    /**
     * @var \User\Mapper\UserMapperInterface $userMapper
     */
    public function __construct(UserMapperInterface $userMapper)
    {
        // Set user mapper
        $this->setUserMapper($userMapper);
        
        // Add elements
        $this
            ->addCsrf()
            ->addEmail()
            ->addId()
            ->addPassword()
            ->addPasswordVerify()
            ->addState()
            ->addUsername()
        ;
    }
    
    /**
     * {@inheritDoc}
     */
    public function addCsrf()
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
     * {@inheritDoc}
     */
    public function addEmail()
    {
        $this->add(array(
            'name'       => 'email',
            'required'   => true,
            'validators' => array(
                array(
                    'name' => 'Zend\Validator\EmailAddress',
                ),
            ),
            'filters' => array(
                array('name' => 'Zend\Filter\HtmlEntities'),
                array('name' => 'Zend\Filter\StringTrim'),
                array('name' => 'Zend\Filter\StripTags'),
            ),
        ));
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function addId()
    {
        $this->add(array(
            'name'     => 'id',
            'required' => true,
            'filters'  => array(
                array('name' => 'Zend\Filter\Int'),
            ),
        ));
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function addPassword()
    {
        $this->add(array(
            'name'     => 'password',
            'required' => true,
            'filters'  => array(
                array('name' => 'Zend\Filter\HtmlEntities'),
                array('name' => 'Zend\Filter\StringTrim'),
                array('name' => 'Zend\Filter\StripTags'),
            ),
        ));
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function addPasswordVerify()
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
                array('name' => 'Zend\Filter\HtmlEntities'),
                array('name' => 'Zend\Filter\StringTrim'),
                array('name' => 'Zend\Filter\StripTags'),
            ),
        ));
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function addState()
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
                array('name' => 'Zend\Filter\HtmlEntities'),
                array('name' => 'Zend\Filter\StringTrim'),
                array('name' => 'Zend\Filter\StripTags'),
            ),
        ));
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function addUsername()
    {
        $this->add(array(
            'name'       => 'username',
            'required'   => true,
            'validators' => array(
                array(
                    'name'    => 'Zend\Validator\Regex',
                    'options' => array(
                        'pattern'  => '/^[a-zA-Z0-9\.\_]*$/',
                        'messages' => array(
                            \Zend\Validator\Regex::NOT_MATCH => 'Value can only contain letters, numbers, dots and underscores.',
                        ),
                    ),
                ),
                array(
                    'name'    => 'Zend\Validator\StringLength',
                    'options' => array(
                        'min' => 4,
                        'max' => 32,
                    ),
                ),
            ),
            'filters' => array(
                array('name' => 'Zend\Filter\HtmlEntities'),
                array('name' => 'Zend\Filter\StringTrim'),
                array('name' => 'Zend\Filter\StripTags'),
            ),
        ));
        
        return $this;
    }
    
    /**
     * Attact filter for the username.
     * 
     * @param string $name
     * @param array  $options
     * 
     * @return \User\InputFilter\UserFilter
     */
    public function attachUsernameFilter($name, array $options = array())
    {
        // Check if element does not exist
        if (!$this->has('username')) {
            // Throw an exception
            throw new \RuntimeException(
                sprintf("Element with name \"%s\" does not exist.", $name)
            );
        }
        
        // Get filter chain
        $filterChain = $this->get('username')->getFilterChain();
        
        // Attach a filter
        $filterChain->attachByName($name, $options);
        
        return $this;
    }
    
    /**
     * Attact validator for the username.
     * 
     * @param string $name
     * @param array  $options
     * 
     * @return \User\InputFilter\UserFilter
     */
    public function attachUsernameValidator($name, array $options = array())
    {
        // Check if element does not exist
        if (!$this->has('username')) {
            // Throw an exception
            throw new \RuntimeException(
                sprintf("Element with name \"%s\" does not exist.", $name)
            );
        }
        
        // Get validator chain
        $validatorChain = $this->get('username')->getValidatorChain();
        
        // Attach a validator
        $validatorChain->attachByName($name, $options);
        
        return $this;
    }
    
    /**
     * Attact filter for the email address.
     * 
     * @param string $name
     * @param array  $options
     * 
     * @return \User\InputFilter\UserFilter
     */
    public function attachEmailFilter($name, array $options = array())
    {
        // Check if element does not exist
        if (!$this->has('email')) {
            // Throw an exception
            throw new \RuntimeException(
                sprintf("Element with name \"%s\" does not exist.", $name)
            );
        }
        
        // Get filter chain
        $filterChain = $this->get('email')->getFilterChain();
        
        // Attach a filter
        $filterChain->attachByName($name, $options);
        
        return $this;
    }
    
    /**
     * Attact validator for the email address.
     * 
     * @param string $name
     * @param array  $options
     * 
     * @return \User\InputFilter\UserFilter
     */
    public function attactEmailValidator($name, array $options = array())
    {
        // Check if element does not exist
        if (!$this->has('email')) {
            // Throw an exception
            throw new \RuntimeException(
                sprintf("Element with name \"%s\" does not exist.", $name)
            );
        }
        
        // Get validator chain
        $validatorChain = $this->get('email')->getValidatorChain();
        
        // Attach a validator
        $validatorChain->attachByName($name, $options);
        
        return $this;
    }
    
    /**
     * Attact filter for the password.
     * 
     * @param string $name
     * @param array  $options
     * 
     * @return \User\InputFilter\UserFilter
     */
    public function attachPasswordFilter($name, array $options = array())
    {
        // Check if element does not exist
        if (!$this->has('password')) {
            // Throw an exception
            throw new \RuntimeException(
                sprintf("Element with name \"%s\" does not exist.", $name)
            );
        }
        
        // Get filter chain
        $filterChain = $this->get('password')->getFilterChain();
        
        // Attach a filter
        $filterChain->attachByName($name, $options);
        
        return $this;
    }
    
    /**
     * Attact validator for the password.
     * 
     * @param string $name
     * @param array  $options
     * 
     * @return \User\InputFilter\UserFilter
     */
    public function attachPasswordValidator($name, array $options = array())
    {
        // Check if element does not exist
        if (!$this->has('password')) {
            // Throw an exception
            throw new \RuntimeException(
                sprintf("Element with name \"%s\" does not exist.", $name)
            );
        }
        
        // Get validator chain
        $validatorChain = $this->get('password')->getValidatorChain();
        
        // Attach a validator
        $validatorChain->attachByName($name, $options);
        
        return $this;
    }
    
    /**
     * Enable the no record exists validator for the username.
     * 
     * @return \User\InputFilter\UserFilter
     */
    public function enableUsernameNoRecordExists()
    {
        // Get user mapper
        $userMapper = $this->getUserMapper();
        
        // Check if user mapper is empty
        if (empty($userMapper)) {
            // Throw an exception
            throw new \RuntimeException(
                sprintf("Element with name \"%s\" does not exist.", $name)
            );
        }
        
        // Attact validator
        return $this->attachUsernameValidator('User\Validator\NoRecordExists', array(
            'field'  => 'username',
            'mapper' => $userMapper,
        ));
    }
    
    /**
     * Enable the record exists validator for the username.
     * 
     * @return \User\InputFilter\UserFilter
     */
    public function enableUsernameRecordExists()
    {
        // Get user mapper
        $userMapper = $this->getUserMapper();
        
        // Check if user mapper is empty
        if (empty($userMapper)) {
            // Throw an exception
            throw new \RuntimeException("User mapper is required, none given.");
        }
        
        // Attact validator
        return $this->attachUsernameValidator('User\Validator\RecordExists', array(
            'field'  => 'username',
            'mapper' => $userMapper,
        ));
    }
    
    /**
     * Enable the unique validator for the username.
     * 
     * @return \User\InputFilter\UserFilter
     */
    public function enableUsernameUniqueRecord()
    {
        // Get user mapper
        $userMapper = $this->getUserMapper();
        
        // Check if user mapper is empty
        if (empty($userMapper)) {
            // Throw an exception
            throw new \RuntimeException("User mapper is required, none given.");
        }
        
        // Add validator
        return $this->attachUsernameValidator('User\Validator\UniqueRecord', array(
            'field'  => 'username',
            'mapper' => $userMapper,
        ));
    }
    
    /**
     * Enable the no record exists validator for the email address.
     * 
     * @return \User\InputFilter\UserFilter
     */
    public function enableEmailNoRecordExists()
    {
        // Get user mapper
        $userMapper = $this->getUserMapper();
        
        // Check if user mapper is empty
        if (empty($userMapper)) {
            // Throw an exception
            throw new \RuntimeException("User mapper is required, none given.");
        }
        
        // Attact validator
        return $this->attactEmailValidator('User\Validator\NoRecordExists', array(
            'field'  => 'email',
            'mapper' => $userMapper,
        ));
    }
    
    /**
     * Enable the record exists validator for the email address.
     * 
     * @return \User\InputFilter\UserFilter
     */
    public function enableEmailRecordExists()
    {
        // Get user mapper
        $userMapper = $this->getUserMapper();
        
        // Check if user mapper is empty
        if (empty($userMapper)) {
            // Throw an exception
            throw new \RuntimeException("User mapper is required, none given.");
        }
        
        // Attact validator
        return $this->attactEmailValidator('User\Validator\RecordExists', array(
            'field'  => 'email',
            'mapper' => $userMapper,
        ));
    }
    
    /**
     * Enable the unique validator for the email address.
     * 
     * @return \User\InputFilter\UserFilter
     */
    public function enableEmailUniqueRecord()
    {
        // Get user mapper
        $userMapper = $this->getUserMapper();
        
        // Check if user mapper is empty
        if (empty($userMapper)) {
            // Throw an exception
            throw new \RuntimeException("User mapper is required, none given.");
        }
        
        // Add validator
        return $this->attactEmailValidator('User\Validator\UniqueRecord', array(
            'field'  => 'email',
            'mapper' => $userMapper,
        ));
    }
    
    /**
     * Enable the string length validator for the password.
     * 
     * @return \User\InputFilter\UserFilter
     */
    public function enablePasswordStringLength()
    {
        // Add validator
        return $this->attachPasswordValidator('Zend\Validator\StringLength', array(
            'min' => 8,
            'max' => 64,
        ));
    }
    
    /**
     * {@inheritDoc}
     */
    public function getUserMapper()
    {
        return $this->userMapper;
    }
    
    /**
     * {@inheritDoc}
     */
    public function setUserMapper(UserMapperInterface $userMapper)
    {
        $this->userMapper = $userMapper;
        
        return $this;
    }
}