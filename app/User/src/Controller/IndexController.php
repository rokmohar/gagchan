<?php

namespace User\Controller;

use Zend\Crypt\Password\Bcrypt;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class IndexController extends AbstractActionController
{
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
        if ($this->user()->hasIdentity() === true) {
            // Redirect to route
            return $this->redirect()->toRoute('home');
        }
        
        // Get request
        $request = $this->getRequest();
        
        // Get form
        $loginForm = $this->getLoginForm();
        
        // Check if page is not posted
        if ($request->isPost() === false) {
            // Return view
            return new ViewModel(array(
                'loginForm' => $loginForm,
            ));
        }
        
        // Set entity prototype
        $loginForm->bind(new \User\Entity\UserEntity());

        // Set posted data
        $loginForm->setData($request->getPost());

        // Check if form is not valid
        if ($loginForm->isValid() === false) {
            // Return view
            return new ViewModel(array(
                'loginForm' => $loginForm,
            ));
        }
        
        // Get auth service
        $authService = $this->user()->getAuthService();
        
        // @todo: find a better solution for this
        $authService->setRequest($this->getRequest());
        
        // Perform authentication
        $result = $authService->authenticate();
        
        // Check if authentication is not valid
        if ($result->isValid() === false) {
            // Set messages
            $loginForm->get('email')->setMessages($result->getMessages());
            
            // Return view
            return new ViewModel(array(
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
     * @return 
     */
    public function signupAction()
    {
        // Get request
        $request = $this->getRequest();
        
        // Get form
        $signupForm = $this->getSignupForm();
        
        // Check if page is not posted
        if ($request->isPost() === false) {
            // Return view
            return new ViewModel(array(
                'signupForm' => $signupForm,
            ));
        }
        
        // Set entity prototype
        $signupForm->bind(new \User\Entity\UserEntity());

        // Set posted data
        $signupForm->setData($request->getPost());

        // Check if form is not valid
        if ($signupForm->isValid() === false) {
            // Return view
            return new ViewModel(array(
                'signupForm' => $signupForm,
            ));
        }
        
        // Get posted data
        $data = $signupForm->getData();
        
        // Encryption service
        $crypt = new Bcrypt(array(
            'cost' => 14,
        ));
        
        // Encrypt password
        $data->setPassword(
            $crypt->create($data->getPassword())
        );
        
        // Insert data
        $this->getUserMapper()->insertRow($data);
        
        // Get mailer
        $mailer = $this->getMailer();
        
        // Send message
        $mailer->sendConfirmationMessage($data);
        
        // @todo: Show message, instead of redirect
        
        // Redirect to route
        return $this->redirect()->toRoute('login');
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