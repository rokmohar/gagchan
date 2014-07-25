<?php

namespace User\Controller;

use Zend\Crypt\Password\Bcrypt;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Core\Utils\TokenGenerator;
use User\Entity\UserEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class IndexController extends AbstractActionController
{
    /**
     * @var \User\Mapper\ConfirmationMapperInterface
     */
    protected $confirmationMapper;
    
    /**
     * @var \User\Form\LoginForm
     */
    protected $loginForm;
    
    /**
     * @var \User\Mailer\MailerInterface
     */
    protected $mailer;
    
    /**
     * @var \User\Form\SignupForm
     */
    protected $signupForm;
    
    /**
     * @var \User\Mapper\UserMapperInterface
     */
    protected $userMapper;
    
    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function loginAction()
    {
        // Check if user has identity
        if ($this->user()->hasIdentity()) {
            // Redirect to route
            return $this->redirect()->toRoute('home');
        }
        
        // Get PRG
        $prg = $this->prg();
        
        // Check if PRG is reponse
        if ($prg instanceof Response) {
            // Return response
            return $prg;
        }
        
        // Get form
        $loginForm = $this->getLoginForm();
        
        // Check if PRG is GET
        if ($prg === false) {
            // Return view
            return new ViewModel(array(
                'messages'  => array(),
                'loginForm' => $loginForm,
            ));
        }
        
        // Set entity prototype
        $loginForm->bind(new \User\Entity\UserEntity());

        // Set data
        $loginForm->setData($prg);
        
        // Check if form is not valid
        if (!$loginForm->isValid()) {
            // Return view
            return new ViewModel(array(
                'messages'  => array(),
                'loginForm' => $loginForm,
            ));
        }
        
        // Get data
        $user = $loginForm->getData();
        
        // Get auth service
        $authService = $this->user()->getAuthService();
        
        // Add param
        $authService->setParams(array(
            'email'    => $user->getEmail(),
            'password' => $user->getPassword(),
        ));
        
        // Perform authentication
        $result = $authService->authenticate();
        
        // Check if authentication is not valid
        if (!$result->isValid()) {
            // Return view
            return new ViewModel(array(
                'messages'  => $result->getMessages(),
                'loginForm' => $loginForm,
            ));
        }
        
        // Redirect to route
        return $this->redirect()->toRoute('home');
    }
    
    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function logoutAction()
    {
        // Get auth service
        $authService = $this->user()->getAuthService();
        
        // Perform logout
        $authService->logout();
        
        // Redirect to route
        return $this->redirect()->toRoute('login');
    }
    
    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function signupAction()
    {
        // Check if user has identity
        if ($this->user()->hasIdentity()) {
            // Redirect to route
            return $this->redirect()->toRoute('home');
        }
        
        // Get PRG
        $prg = $this->prg();
        
        // Check if PRG is response
        if ($prg instanceof Response) {
            // Return response
            return $prg;
        }
        
        // Get form
        $signupForm = $this->getSignupForm();
        
        // Check if PRG is GET
        if ($prg === false) {
            // Return view
            return new ViewModel(array(
                'signupForm' => $signupForm,
            ));
        }
        
        // Set entity prototype
        $signupForm->bind(new \User\Entity\UserEntity());

        // Set posted data
        $signupForm->setData($prg);

        // Check if form is not valid
        if (!$signupForm->isValid()) {
            // Return view
            return new ViewModel(array(
                'signupForm' => $signupForm,
            ));
        }
        
        // Get posted data
        $user = $signupForm->getData();
        
        // Encryption service
        $crypt = new Bcrypt(array(
            'cost' => 14,
        ));
        
        // Encrypt password
        $user->setPassword(
            $crypt->create($user->getPassword())
        );
        
        // Set state
        $user->setState(UserEntityInterface::STATE_UNCONFIRMED);
        
        // Insert data
        $this->getUserMapper()->insertRow($user);
        
        // Get confirmation mapper
        $confirmationMapper = $this->getConfirmationMapper();
        
        // Create confirmation
        $confirmation = new \User\Entity\ConfirmationEntity();
        
        $confirmation->setUserId($user->getId());
        $confirmation->setEmail($user->getEmail());
        $confirmation->setRemoteAddress(
            $this->getRequest()->getServer('REMOTE_ADDR')
        );
        $confirmation->setRequestAt(new \DateTime());
        $confirmation->setRequestToken($this->generateToken());
        $confirmation->setConfirmedAt();
        $confirmation->setIsConfirmed(false);
        
        // Insert confirmation
        $confirmationMapper->insertRow($confirmation);
        
        // Get mailer
        $mailer = $this->getMailer();
        
        // Send message
        $mailer->sendConfirmationMessage($user, $confirmation);
        
        // Create view
        $view = new ViewModel(array(
            'user' => $user,
        ));
        
        // Set template
        $view->setTemplate('user/index/signup_success');
        
        // Return view
        return $view;
    }
    
    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function confirmAction()
    {
        // Get confirmation mapper
        $confirmationMapper = $this->getConfirmationMapper();
        
        // Get confirmation
        $confirmation = $confirmationMapper->selectNotConfirmed(
            $this->params()->fromRoute('id'),
            $this->params()->fromRoute('token')
        );
        
        // Check if confirmation is empty
        if (empty($confirmation)) {
            // Confirmation not found
            return $this->notFoundAction();
        }
        
        // Get user mapper
        $userMapper = $this->getUserMapper();
        
        // Get user
        $user = $userMapper->selectRowById($confirmation->getUserId());
        
        // Set state
        $user->setState(UserEntityInterface::STATE_CONFIRMED);
        
        // Update user
        $userMapper->updateRow($user);
        
        // Set as confirmed
        $confirmation->setConfirmedAt(new \DateTime());
        $confirmation->setIsConfirmed(true);
        
        // Update confirmation
        $confirmationMapper->updateRow($confirmation);
        
        // Create view
        $view = new ViewModel();
        
        // Set template
        $view->setTemplate('user/index/confirm');
        
        // Return view
        return $view;
    }
    
    /**
     * Generate random token.
     * 
     * @return string
     */
    public function generateToken()
    {
        // Get token generator
        $generator = new TokenGenerator();
        
        // Generate token
        return $generator->getToken(32);
    }
    
    /**
     * Return the confirmation mapper.
     * 
     * @return \User\Mapper\ConfirmationMapperInterface
     */
    public function getConfirmationMapper()
    {
        if ($this->confirmationMapper === null) {
            return $this->confirmationMapper = $this->getServiceLocator()->get(
                'user.mapper.confirmation'
            );
        }
        
        return $this->confirmationMapper;
    }
    
    /**
     * Return the login form.
     * 
     * @return \User\Form\LoginForm
     */
    public function getLoginForm()
    {
        if ($this->loginForm === null) {
            return $this->loginForm = $this->getServiceLocator()->get(
                'user.form.login'
            );
        }
        
        return $this->loginForm;
    }
    
    /**
     * Return the mailer.
     * 
     * @return \User\Mailer\MailerInterface
     */
    public function getMailer()
    {
        if ($this->mailer === null) {
            return $this->mailer = $this->getServiceLocator()->get(
                'user.mailer.amazon'
            );
        }
        
        return $this->mailer;
    }
    
    /**
     * Return the signup form.
     * 
     * @return \User\Form\LoginForm
     */
    public function getSignupForm()
    {
        if ($this->signupForm === null) {
            return $this->signupForm = $this->getServiceLocator()->get(
                'user.form.signup'
            );
        }
        
        return $this->signupForm;
    }
    
    /**
     * Return the user mapper.
     * 
     * @return \User\Mapper\UserMapperInterface
     */
    public function getUserMapper()
    {
        if ($this->userMapper === null) {
            return $this->userMapper = $this->getServiceLocator()->get(
                'user.mapper.user'
            );
        }
        
        return $this->userMapper;
    }
}