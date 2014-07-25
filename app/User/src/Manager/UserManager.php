<?php

namespace User\Manager;

use Zend\Authentication\AuthenticationServiceInterface;
use Zend\Crypt\Password\Bcrypt;
use Zend\Http\Request;
use Zend\ServiceManager\ServiceLocatorInterface;

use User\Entity\UserEntityInterface;
use User\Form\UserForm;
use User\Mailer\MailerInterface;
use User\Mapper\ConfirmationMapperInterface;
use User\Mapper\UserMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class UserManager implements UserManagerInterface
{
    /**
     * @var \User\Mapper\ConfirmationMapperInterface
     */
    protected $confirmationMapper;
    
    /**
     * @var \Zend\Authentication\AuthenticationServiceInterface
     */
    protected $authService;
    
    /**
     * @var \User\Mailer\MailerInterface
     */
    protected $mailer;
    
    /**
     * @var \Zend\Stdlib\RequestInterface
     */
    protected $request;
    
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
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     */
    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }
    
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
     * Perform a recovery request.
     * 
     * @param array $data
     */
    public function recoverRequest(array $data)
    {
        die("@todo: No method logic");
    }
    
    /**
     * Perform a recovery reset.
     * 
     * @param array $reset
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
        $signupForm = $this->getUserForm();
        
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
     * Perform a sign up confirmation.
     * 
     * @param array $data
     * 
     * @return UNKNOWN
     */
    public function registerConfirm(array $data)
    {
        die("@todo: No method logic");
    }
    
    /**
     * Send a confirmation email message.
     * 
     * @param array $data
     * 
     * @return mixed
     */
    public function sendConfirmationMessage(array $data)
    {
        var_dump($data); die();
        
        // Create confirmation entity
        $confirmation = new \User\Entity\ConfirmationEntity();
        
        $confirmation->setUserId($user->getId());
        $confirmation->setEmail($user->getEmail());
        $confirmation->setRemoteAddress(
            $this->getRequest()->getServer('REMOTE_ADDR')
        );
        $confirmation->setRequestAt(new \DateTime());
        $confirmation->setRequestToken($this->generateToken());
        //$confirmation->setConfirmedAt();
        $confirmation->setIsConfirmed(false);
        
        // Get confirmation mapper
        $confirmationMapper = $this->getConfirmationMapper();
        
        // Insert a row
        $confirmationMapper->insertRow($confirmation);
        
        // Get mailer
        $mailer = $this->getMailer();
        
        // Send confirmation message
        return $mailer->sendConfirmationMessage($user, $confirmation);
    }
    
    /**
     * Send a recover email message.
     * 
     * @param array $data
     * 
     * @return mixed
     */
    public function sendRecoverMessage(array $data)
    {
        var_dump($data); die();
        
        // Create class
        $recover = new \User\Entity\RecoverEntity();
        
        $recover->setUserId($user->getId());
        $recover->setEmail($user->getEmail());
        $recover->setRemoteAddress(
            $this->getRequest()->getServer('REMOTE_ADDR')
        );
        $recover->setRequestAt(new \DateTime());
        $recover->setRequestToken($this->generateToken());
        $recover->setRecoveredAt();
        $recover->setIsRecovered(false);
        
        // Get recover mapper
        $this->getRecoverMapper()->insertRow($recover);
        
        // Send message
        return $this->getMailer()->sendRecoverMessage($user, $recover);
    }
    
    /**
     * Return the authentication service.
     * 
     * @return \Zend\Authentication\AuthenticationServiceInterface
     */
    public function getAuthService()
    {
        // Check if authentication service is empty
        if ($this->authService === null) {
            // Set the authentication service
            $this->setAuthService($this->getServiceLocator()->get(
                'user.auth.service'
            ));
        }
        
        return $this->authService;
    }
    
    /**
     * Set the authentication service.
     * 
     * @param \Zend\Authentication\AuthenticationServiceInterface $authService
     */
    public function setAuthService(AuthenticationServiceInterface $authService)
    {
        $this->authService = $authService;
        
        return $this;
    }
    
    /**
     * Return the confirmation mapper.
     * 
     * @return \User\Mapper\ConfirmationMapperInterface
     */
    public function getConfirmationMapper()
    {
        // Check if confirmation mapper is empty
        if ($this->confirmationMapper === null) {
            // Set the confirmation mapper
            $this->setConfirmationMapper($this->getServiceLocator()->get(
                'user.mapper.confirmation'
            ));
        }
        
        return $this->confirmationMapper;
    }
    
    /**
     * Set the confirmation mapper.
     * 
     * @param \User\Mapper\ConfirmationMapperInterface $confirmationMapper
     */
    public function setConfirmationMapper(ConfirmationMapperInterface $confirmationMapper)
    {
        $this->confirmationMapper = $confirmationMapper;
        
        return $this;
    }
    
    /**
     * Return the mailer.
     * 
     * @return \User\Mailer\MailerInterface
     */
    public function getMailer()
    {
        // Check if mailer is empty
        if ($this->mailer === null) {
            // Set the mailer
            $this->setMailer($this->getServiceLocator()->get(
                'user.mailer.amazon'
            ));
        }
        
        return $this->mailer;
    }
    
    /**
     * Return the request.
     *
     * @return \Zend\Stdlib\RequestInterface
     */
    public function getRequest()
    {
        if (!$this->request) {
            $this->request = new Request();
        }

        return $this->request;
    }
    
    /**
     * Set the mailer.
     * 
     * @param \User\Mailer\MailerInterface $mailer
     */
    public function setMailer(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
        
        return $this;
    }
    
    /**
     * Return the service locator.
     * 
     * @return \Zend\ServiceManager\ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
    
    /**
     * Return the user form.
     * 
     * @return \User\Form\UserForm
     */
    public function getSignupForm()
    {
        // Check if user form is empty
        if ($this->signupForm === null) {
            // Set the user form
            $this->setUserForm($this->getServiceLocator()->get(
                'user.form.signup'
            ));
        }
        
        return $this->signupForm;
    }
    
    /**
     * Set the user form.
     * 
     * @param \User\Form\UserForm $userForm
     */
    public function setUserForm(UserForm $userForm)
    {
        $this->userForm = $userForm;
        
        return $this;
    }
    
    /**
     * Return the user mapper.
     * 
     * @return \User\Mapper\UserMapperInterface
     */
    public function getUserMapper()
    {
        // Check if user manager is empty
        if ($this->userMapper === null) {
            // Set the user manager
            $this->setUserManager($this->getServiceLocator()->get(
                'user.mapper.user'
            ));
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
