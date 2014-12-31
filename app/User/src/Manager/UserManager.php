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
     * @var \User\Form\User\UserFormInterface
     */
    protected $accountForm;
    
    /**
     * @var \Zend\Authentication\AuthenticationServiceInterface
     */
    protected $authService;
    
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
        // @TBD
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
        // Get form
        $form = $this->getSignupForm();
        
        // Get entity class
        $userClass = $this->getUserOptions()->getUserEntityClass();
        
        // Bind entity class
        $form->bind(new $userClass);
        
        // Set data
        $form->setData($data);
        
        // Check if form data is valid
        if ($form->isValid()) {
            // Get data
            $user = $form->getData();

            // Set default data
            $user->setPassword($this->encryptPassword($user->getPassword()));
            $user->setState(UserEntityInterface::STATE_UNCONFIRMED);

            // Insert row
            $this->getUserMapper()->insertRow($user);
            
            return $user;
        }
    
        return false;
    }
    
    /**
     * {@inheritDoc}
     */
    public function updateUser(UserEntityInterface $user, array $data)
    {
        // Get form
        $signupForm = $this->getSignupForm();
        
        // Bind entity class
        $signupForm->bind($user);
        
        // Set data
        $signupForm->setData($data);
        
        // Check if form data is valid
        if ($signupForm->isValid()) {
            // Get data
            $user = $signupForm->getData();

            // Encrypt password
            $user->setPassword($this->encryptPassword($user->getPassword()));

            // Update row
            $this->getUserMapper()->updateRow($user);
            
            return $user;
        }
        
        return false;
    }
    
    /**
     * {@inheritDoc}
     */
    public function encryptPassword($password)
    {
        // Encryption service
        $crypt = new Bcrypt(array(
            'cost' => 14,
        ));
        
        return $crypt->create($password);
    }
    
    /**
     * {@inheritDoc}
     */
    public function getAccountForm()
    {
        if ($this->accountForm === null) {
            // Set account form
            $this->accountForm = $this->getServiceLocator()->get('user.form.user.account');
        }
        
        return $this->accountForm;
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
     * {@inheritDoc}
     */
    public function getLoginForm()
    {
        if ($this->loginForm === null) {
            // Set login form
            $this->loginForm = $this->getServiceLocator()->get('user.form.user.login');
        }
        
        return $this->loginForm;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getPasswordForm()
    {
        if ($this->passwordForm === null) {
            // Set password form
            $this->passwordForm = $this->getServiceLocator()->get('user.form.user.password');
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
     * {@inheritDoc}
     */
    public function getSignupForm()
    {
        if ($this->signupForm === null) {
            // Set signup form
            $this->signupForm = $this->getServiceLocator()->get('user.form.user.signup');
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
}
