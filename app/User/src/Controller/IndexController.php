<?php

namespace User\Controller;

use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

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
     * @var \User\Manager\ConfirmationManagerInterface
     */
    protected $confirmationManager;
    
    /**
     * @var \User\Form\LoginForm
     */
    protected $loginForm;
    
    /**
     * @var \User\Form\SignupForm
     */
    protected $signupForm;
    
    /**
     * @var \User\Manager\UserManagerInterface
     */
    protected $userManager;
    
    /**
     * @var \User\Mapper\UserMapperInterface
     */
    protected $userMapper;
    
    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function loginAction()
    {
        // Redirect, iff user is not logged in
        if ($this->user()->hasIdentity()) {
            return $this->redirect()->toRoute('home');
        }
        
        // Get PRG
        $prg = $this->prg();
        
        // Redirect, iff PRG is response
        if ($prg instanceof Response) {
            return $prg;
        }
        
        // Get form
        $loginForm = $this->getLoginForm();
        
        // Return view, iff PRG is GET request
        if ($prg === false) {
            return new ViewModel(array(
                'messages'  => array(),
                'loginForm' => $loginForm,
            ));
        }
        
        // Set form data
        $loginForm->setData($prg);
        
        // Return view, iff form is not valid
        if (!$loginForm->isValid()) {
            return new ViewModel(array(
                'messages'  => array(),
                'loginForm' => $loginForm,
            ));
        }
        
        // Get user manager
        $userManager = $this->getUserManager();
        
        // Perform authentication
        $result = $userManager->authenticate($loginForm->getData());
        
        // Return view, iff authentication is not valid
        if (!$result->isValid()) {
            return new ViewModel(array(
                'messages'  => $result->getMessages(),
                'loginForm' => $loginForm,
            ));
        }
        
        // Redirect
        return $this->redirect()->toRoute('home');
    }
    
    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function logoutAction()
    {
        // Get user manager
        $userManager = $this->getUserManager();
        
        // Perform a logout
        $userManager->logout();
        
        // Redirect to route
        return $this->redirect()->toRoute('login');
    }
    
    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function signupAction()
    {
        // Redirect, iff user has identity
        if ($this->user()->hasIdentity()) {
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
        
        // Return view, iff PRG is GET
        if ($prg === false) {
            return new ViewModel(array(
                'signupForm' => $signupForm,
            ));
        }
        
        // Get user manager
        $userManager = $this->getUserManager();
        
        // Perform a registration
        $user = $userManager->createUser($prg);
        
        // Return view, iff form is not valid
        if (empty($user)) {
            return new ViewModel(array(
                'signupForm' => $signupForm,
            ));
        }
        
        // Send a confirmation message
        $userManager->sendConfirmationMessage(array(
            'request' => $this->getRequest(),
            'user'    => $user,
        ));
        
        // Create view
        $view = new ViewModel(array(
            'user' => $user,
        ));
        
        // Change template
        $view->setTemplate('user/index/signup_success');
        
        // Return view
        return $view;
    }
    
    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function confirmAction()
    {
        // Check if user has identity
        if ($this->user()->hasIdentity()) {
            // Redirect to route
            return $this->redirect()->toRoute('home');
        }
        
        // Get confirmation mapper
        $confirmationMapper = $this->getConfirmationMapper();
        
        // Get confirmation
        $confirmation = $confirmationMapper->selectNotConfirmed(
            $this->params()->fromRoute('id'),
            $this->params()->fromRoute('token')
        );
        
        // Return not found, iff confirmation is empty
        if (empty($confirmation)) {
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
     * Return the confirmation mapper.
     * 
     * @return \User\Mapper\ConfirmationMapperInterface
     */
    public function getConfirmationMapper()
    {
        if ($this->confirmationMapper === null) {
            // Get confirmation mapper
            $this->confirmationMapper = $this->getServiceLocator()->get('user.mapper.confirmation');
        }
        
        return $this->confirmationMapper;
    }
    
    /**
     * Return the confirmation manager.
     * 
     * @return \User\Manager\ConfirmationManagerInterface
     */
    public function getConfirmationManager()
    {
        if ($this->confirmationManager === null) {
            // Get confirmation manager
            $this->confirmationManager = $this->getServiceLocator()->get('user.manager.confirmation');
        }
        
        return $this->confirmationManager;
    }
    
    /**
     * Return the login form.
     * 
     * @return \User\Form\LoginForm
     */
    public function getLoginForm()
    {
        if ($this->loginForm === null) {
            // Get login form
            $this->loginForm = $this->getServiceLocator()->get('user.form.user.login');
        }
        
        return $this->loginForm;
    }
    
    /**
     * Return the signup form.
     * 
     * @return \User\Form\LoginForm
     */
    public function getSignupForm()
    {
        if ($this->signupForm === null) {
            // Get signup form
            $this->signupForm = $this->getServiceLocator()->get('user.form.user.signup');
        }
        
        return $this->signupForm;
    }
    
    /**
     * Return the user manager.
     * 
     * @return \User\Manager\UserManagerInterface
     */
    public function getUserManager()
    {
        if ($this->userManager === null) {
            // Get user manager
            $this->userManager = $this->getServiceLocator()->get('user.manager.user');
        }
        
        return $this->userManager;
    }
    
    /**
     * Return the user mapper.
     * 
     * @return \User\Mapper\UserMapperInterface
     */
    public function getUserMapper()
    {
        if ($this->userMapper === null) {
            // Get user mapper
            $this->userMapper = $this->getServiceLocator()->get('user.mapper.user');
        }
        
        return $this->userMapper;
    }
}