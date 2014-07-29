<?php

namespace User\Manager;

use Zend\Authentication\AuthenticationServiceInterface;
use Zend\Crypt\Password\Bcrypt;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use User\Entity\UserEntityInterface;
use User\Form\UserForm;
use User\Mapper\UserMapperInterface;
use User\Options\UserOptionsInterface;

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
     * @var \User\Form\UserForm
     */
    protected $signupForm;
    
    /**
     * @var \User\Mapper\UserMapperInterface
     */
    protected $userMapper;
    
    /**
     * @var \User\Options\UserOptionsInterface
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
    public function recoverRequest(array $data)
    {
        die("@todo: No method logic");
    }
    
    /**
     * {@inheritDoc}
     */
    public function recoverReset(array $data)
    {
        die("@todo: No method logic");
    }
    
    /**
     * {@inheritDoc}
     */
    public function register(array $data)
    {
        // Get form
        $signupForm = $this->getSignupForm();
        
        // Bind entity
        $signupForm->bind(new \User\Entity\UserEntity());
        
        // Set data
        $signupForm->setData($data);
        
        // Check if form is not valid
        if (!$signupForm->isValid()) {
            // Validation failed
            return false;
        }
        
        // Get data
        $user = $signupForm->getData();
        
        // Encryption service
        $crypt = new Bcrypt(array(
            'cost' => 14,
        ));
        
        // Encrypt the password
        $user->setPassword($crypt->create($user->getPassword()));
        
        // Set defautl state
        $user->setState(UserEntityInterface::STATE_UNCONFIRMED);
        
        // Insert a row
        $this->getUserMapper()->insertRow($user);
        
        // Return user
        return $user;
    }
    
    /**
     * {@inheritDoc}
     */
    public function registerConfirm(array $data)
    {
        die("@todo: No method logic");
    }
    
    /**
     * Generate random token.
     * 
     * @return string
     */
    public function generateToken()
    {
        // Get token generator
        $generator = \Core\Utils\TokenGenerator::getInstance();
        
        // Generate token
        return $generator->getToken(32);
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
            $this->setSignupForm($this->getServiceLocator()->get('user.form.signup'));
        }
        
        return $this->signupForm;
    }
    
    /**
     * {@inheritDoc}
     */
    public function setSignupForm(UserForm $signupForm)
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
    public function setUserOptions(UserOptionsInterface $userOptions)
    {
        $this->userOptions = $userOptions;
        
        return $this;
    }
}
