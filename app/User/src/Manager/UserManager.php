<?php

namespace User\Manager;

use Zend\Crypt\Password\Bcrypt;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use User\Entity\UserEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class UserManager implements UserManagerInterface, ServiceLocatorAwareInterface
{
    /**
     * @var \Zend\Authentication\AuthenticationServiceInterface
     */
    protected $authService;
    
    /**
     * @var \User\Form\UserFormInterface
     */
    protected $emailForm;
    
    /**
     * @var \User\Form\User\UserFormInterface
     */
    protected $loginForm;
    
    /**
     * @var \User\Form\User\UserFormInterface
     */
    protected $passwordForm;
    
    /**
     * @var \Zend\ServiceManager\ServiceLocatorInterface
     */
    protected $serviceLocator;
    
    /**
     * @var \User\Form\User\UserFormInterface
     */
    protected $settingsForm;
    
    /**
     * @var \User\Form\User\UserFormInterface
     */
    protected $signupForm;
    
    /**
     * @var \User\Mapper\UserMapperInterface
     */
    protected $userMapper;
    
    /**
     * @var \User\Options\UserOptions
     */
    protected $userOptions;
    
    /**
     * @var \User\Mapper\UserMapperInterface
     */
    protected $usernameForm;
    
    /**
     * {@inheritDoc}
     */
    public function authenticate(array $params = array())
    {
        // Get auth service
        $authService = $this->getAuthService();
        
        // Set parameters
        $authService->setParams($params);
        
        // Perform authentication
        return $authService->authenticate();
    }
    
    /**
     * {@inheritDoc}
     */
    public function login(array $data)
    {
        // Post login form
        $result = $this->postLogin($data);
        
        // Return authentication result
        return is_array($result) ? $this->authenticate($result) : false;
    }
    
    /**
     * {@inheritDoc}
     */
    public function logout(array $params = array())
    {
        // Get auth service
        $authService = $this->getAuthService();
        
        // Set parameters
        $authService->setParams($params);
        
        // Perform logout
        $authService->logout();
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function createUser(array $data)
    {
        // Post signup form
        $result = $this->postSignup($data);
        
        // Check if result is valid
        if ($result instanceof UserEntityInterface) {
            // Set encrypted password
            $result->setPassword($this->encryptPassword($result->getPassword()));
            
            // Get user mapper
            $userMapper = $this->getUserMapper();
            
            // Insert row
            $userMapper->insertRow($result);
            
            // Return result
            return $result;
        }
        
        return false;
    }
    
    /**
     * {@inheritDoc}
     */
    public function updateUser(UserEntityInterface $user, array $data, $encryptPassword = false)
    {
        // Post settings form
        $result = $this->postSettings($user, $data);
        
        // Check if result is valid
        if ($result instanceof UserEntityInterface) {
            // Encrypt password if flagged
            if ($encryptPassword === true) {
                // Set password
                $result->setPassword($this->encryptPassword($result->getPassword()));
            }
            
            // Get user mapper
            $userMapper = $this->getUserMapper();
            
            // Update row
            $userMapper->updateRow($result);
            
            // Return result
            return $result;
        }
        
        return false;
    }
    
    /**
     * Find user through email form.
     * 
     * @return \User\Entity\UserEntityInterface
     */
    public function findByEmail(array $data)
    {
        // Post email form
        $result = $this->postEmail($data);
        
        // Check if form data is valid
        if (is_array($result)) {
            // Get user mapper
            $userMapper = $this->getUserMapper();
            
            // Return row
            return $userMapper->selectRow($result);
        }
        
        return false;
    }
    
    /**
     * Find user through username form.
     * 
     * @return \User\Entity\UserEntityInterface
     */
    public function findByUsername(array $data)
    {
        // Post username form
        $result = $this->postUsername($data);
        
        // Check if form data is valid
        if (is_array($result)) {
            // Get user mapper
            $userMapper = $this->getUserMapper();
            
            // Return row
            return $userMapper->selectRow($result);
        }
        
        return false;
    }
    
    /**
     * Post email form.
     * 
     * @param array $data
     * 
     * @return array
     */
    public function postEmail(array $data)
    {
        // Get form
        $form = $this->getEmailForm();
        
        // Set data
        $form->setData($data);
        
        // Return form data
        return $form->isValid() ? $form->getData() : false;
    }
    
    /**
     * Post login form.
     * 
     * @param array $data
     * 
     * @return array
     */
    public function postLogin(array $data)
    {
        // Get form
        $form = $this->getLoginForm();
        
        // Set data
        $form->setData($data);
        
        // Return form data
        return $form->isValid() ? $form->getData() : false;
    }
    
    /**
     * Post password form.
     * 
     * @param array $data
     * 
     * @return array
     */
    public function postPassword(array $data)
    {
        // Get form
        $form = $this->getPasswordForm();
        
        // Set data
        $form->setData($data);
        
        // Return form data
        return $form->isValid() ? $form->getData() : false;
    }
    
    /**
     * Post settings form.
     * 
     * @param \User\Entity\UserEntityInterface $user
     * @param array                            $data
     * 
     * @return \User\Entity\UserEntityInterface
     */
    public function postSettings(UserEntityInterface $user, array $data)
    {
        // Get form
        $form = $this->getSettingsForm();
        
        // Bind entity class
        $form->bind($user);
        
        // Set data
        $form->setData($data);
        
        // Return form data
        return $form->isValid() ? $form->getData() : false;
    }
    
    /**
     * Post signup form.
     * 
     * @param array $data
     * 
     * @return \User\Entity\UserEntityInterface
     */
    public function postSignup(array $data)
    {
        // Get form
        $form = $this->getSignupForm();
        
        // Get entity class
        $class = $this->getUserOptions()->getUserEntityClass();
        
        // Bind entity class
        $form->bind(new $class);
        
        // Set data
        $form->setData($data);
        
        // Return form data
        return $form->isValid() ? $form->getData() : false;
    }
    
    /**
     * Post username form.
     * 
     * @param array $data
     * 
     * @return array
     */
    public function postUsername(array $data)
    {
        // Get form
        $form = $this->getUsernameForm();
        
        // Set data
        $form->setData($data);
        
        // Return form data
        return $form->isValid() ? $form->getData() : false;
    }
    
    /**
     * {@inheritDoc}
     */
    public function encryptPassword($password)
    {
        // Create encryptor
        $crypt = new Bcrypt(array(
            'cost' => 14,
        ));
        
        // Create password
        return $crypt->create($password);
    }
    
    /**
     * {@inheritDoc}
     */
    public function getAuthService()
    {
        if ($this->authService === null) {
            // Set auth service
            $this->authService = $this->getServiceLocator()->get('user.auth.service');
        }
        
        return $this->authService;
    }
    
    /**
     * @return \User\Form\UserFormInterface
     */
    public function getEmailForm()
    {
        if ($this->emailForm === null) {
            // Set email form
            $this->emailForm = $this->getServiceLocator()->get('user.form.email');
        }
        
        return $this->emailForm;
    }
    
    /**
     * @return \User\Form\UserFormInterface
     */
    public function getLoginForm()
    {
        if ($this->loginForm === null) {
            // Set login form
            $this->loginForm = $this->getServiceLocator()->get('user.form.login');
        }
        
        return $this->loginForm;
    }
    
    /**
     * @return \User\Form\UserFormInterface
     */
    public function getPasswordForm()
    {
        if ($this->passwordForm === null) {
            // Set password form
            $this->passwordForm = $this->getServiceLocator()->get('user.form.password');
        }
        
        return $this->passwordForm;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
    
    /**
     * {@inheritDoc}
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        
        return $this;
    }
    
    /**
     * @return \User\Form\UserFormInterface
     */
    public function getSettingsForm()
    {
        if ($this->settingsForm === null) {
            // Set settings form
            $this->settingsForm = $this->getServiceLocator()->get('user.form.settings');
        }
        
        return $this->settingsForm;
    }
    
    /**
     * @return \User\Form\UserFormInterface
     */
    public function getSignupForm()
    {
        if ($this->signupForm === null) {
            // Set signup form
            $this->signupForm = $this->getServiceLocator()->get('user.form.signup');
        }
        
        return $this->signupForm;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getUserMapper()
    {
        if ($this->userMapper === null) {
            // Set user mapper
            $this->userMapper = $this->getServiceLocator()->get('user.mapper.user');
        }
        
        return $this->userMapper;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getUserOptions()
    {
        if ($this->userOptions === null) {
            // Set user options
            $this->userOptions = $this->getServiceLocator()->get('user.options.user');
        }
        
        return $this->userOptions;
    }
    
    /**
     * @return \User\Form\UserFormInterface
     */
    public function getUsernameForm()
    {
        if ($this->usernameForm === null) {
            // Set username form
            $this->usernameForm = $this->getServiceLocator()->get('user.form.username');
        }
        
        return $this->usernameForm;
    }
}
