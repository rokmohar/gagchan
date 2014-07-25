<?php

namespace User\Manager;

use Zend\Authentication\AuthenticationServiceInterface;
use Zend\Crypt\Password\Bcrypt;
use Zend\ServiceManager\ServiceLocatorInterface;

use User\Form\UserForm;
use User\Mailer\MailerInterface;
use User\Mapper\UserMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class UserManager implements UserManagerInterface
{
    /**
     * @var \Zend\Authentication\AuthenticationServiceInterface
     */
    protected $authService;
    
    /**
     * @var \User\Mailer\MailerInterface
     */
    protected $mailer;
    
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
     * Perform an authentication.
     * 
     * @param array $params
     * 
     * @return \Zend\Authentication\Result
     */
    public function authenticate(array $params)
    {
        // Get authentication service
        $authService = $this->getAuthService();
        
        // Set authentication params
        $authService->setParams($params);
        
        // Perform an authentication
        return $authService->authenticate();
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
     * Perform a logout.
     * 
     * @return \User\Manager\UserManagerInterface
     */
    public function logout()
    {
        // Get authentication service
        $authService = $this->getAuthService();
        
        // Perform a logout
        $authService->logout();
        
        return $this;
    }
    
    /**
     * Perform a sign up.
     * 
     * @param array $data
     * 
     * @return mixed
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
     * @param \User\Entity\UserEntityInteface $user
     * 
     * @return mixed
     */
    public function sendConfirmationMessage(UserEntityInteface $user)
    {
        // Get confirmation mapper
        $confirmationMapper = $this->getConfirmationMapper();
        
        // Create confirmation entity
        $confirmation = new \User\Entity\ConfirmationEntity();
        
        // @todo: How to get a remote address?
        die("@todo: How to get a remote address");
        
        $confirmation->setUserId($user->getId());
        $confirmation->setEmail($user->getEmail());
        /*$confirmation->setRemoteAddress(
            $this->getRequest()->getServer('REMOTE_ADDR')
        );*/
        $confirmation->setRequestAt(new \DateTime());
        $confirmation->setRequestToken($this->generateToken());
        //$confirmation->setConfirmedAt();
        $confirmation->setIsConfirmed(false);
        
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
     * @param \User\Entity\UserEntityInteface $user
     * 
     * @return mixed
     */
    public function sendRecoverMessage(UserEntityInteface $user)
    {
        
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
