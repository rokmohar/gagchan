<?php

namespace User\Manager;

use Zend\Authentication\AuthenticationServiceInterface;
use Zend\Crypt\Password\Bcrypt;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use User\Entity\UserEntityInterface;
use User\Form\User\UserFormInterface;
use User\Mapper\UserMapperInterface;
use User\Options\UserOptions;

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
        
        // Perform an authentication
        return $authService->authenticate();
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
        
        // Perform a logout
        $authService->logout();
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function createUser(array $data)
    {
        // Get form
        $signupForm = $this->getSignupForm();
        
        // Get class
        $userClass = $this->getUserOptions()->getUserEntityClass();
        
        // Bind entity
        $signupForm->bind(new $userClass);
        
        // Set data
        $signupForm->setData($data);
        
        // Check if form is not valid
        if (!$signupForm->isValid()) {
            // Validation failed
            return false;
        }
        
        // Get data
        $user = $signupForm->getData();
        
        var_dump($user);
        
        // Encrypt password
        $user->setPassword($this->encryptPassword($user->getPassword()));
        
        // Set state
        $user->setState(UserEntityInterface::STATE_UNCONFIRMED);
        
        // Insert a row
        return $this->getUserMapper()->insertRow($user);
    }
    
    /**
     * {@inheritDoc}
     */
    public function updateUser(array $data)
    {
        // Get form
        $signupForm = $this->getSignupForm();
        
        // Get class
        //$userClass = $this->getUserOptions()->getUserEntityClass();
        
        // Bind entity
        //$signupForm->bind(new \User\Entity\UserEntity());
        
        // Set data
        $signupForm->setData($data);
        
        // Check if form is not valid
        if (!$signupForm->isValid()) {
            // Validation failed
            return false;
        }
        
        // Get data
        $user = $signupForm->getData();
        
        var_dump($user);
        
        // Encrypt password
        $user->setPassword($this->encryptPassword($user->getPassword()));
        
        // Update a row
        return $this->getUserMapper()->updateRow($user);
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
    public function getAuthService()
    {
        if ($this->authService === null) {
            $this->setAuthService($this->getServiceLocator()->get('user.auth.service'));
        }
        
        return $this->authService;
    }
    
    /**
     * {@inheritDoc}
     */
    public function setAuthService(AuthenticationServiceInterface $authService)
    {
        $this->authService = $authService;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getConfirmationForm()
    {
        if ($this->confirmationForm === null) {
            $this->setConfirmationForm($this->getServiceLocator()->get('user.form.confirmation'));
        }
        
        return $this->confirmationForm;
    }
    
    /**
     * {@inheritDoc}
     */
    public function setConfirmationForm(ConfirmationFormInterface $confirmationForm)
    {
        $this->confirmationForm = $confirmationForm;
        
        return $this;
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
            $this->setSignupForm($this->getServiceLocator()->get('user.form.user.signup'));
        }
        
        return $this->signupForm;
    }
    
    /**
     * {@inheritDoc}
     */
    public function setSignupForm(UserFormInterface $signupForm)
    {
        $this->signupForm = $signupForm;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getUserMapper()
    {
        if ($this->userMapper === null) {
            $this->setUserMapper($this->getServiceLocator()->get('user.mapper.user'));
        }
        
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
    
    /**
     * {@inheritDoc}
     */
    public function getUserOptions()
    {
        if ($this->userOptions === null) {
            $this->setUserOptions($this->getServiceLocator()->get('user.options.user'));
        }
        
        return $this->userOptions;
    }
    
    /**
     * {@inheritDoc}
     */
    public function setUserOptions(UserOptions $userOptions)
    {
        $this->userOptions = $userOptions;
        
        return $this;
    }
}
