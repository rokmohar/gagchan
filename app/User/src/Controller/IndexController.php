<?php

namespace User\Controller;

use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class IndexController extends AbstractActionController
{
    /**
     * @var \User\Manager\ConfirmationManagerInterface
     */
    protected $confirmationManager;
    
    /**
     * @var \User\Manager\UserManagerInterface
     */
    protected $userManager;
    
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
        
        // Get user manager
        $userManager = $this->getUserManager();
        
        // Get form
        $form = $userManager->getLoginForm();
        
        // Return view, iff PRG is GET request
        if ($prg === false) {
            return new ViewModel(array(
                'messages'  => array(),
                'loginForm' => $form,
            ));
        }
        
        // Perform login
        $result = $userManager->login($prg);
        
        // Return view, iff form is not valid
        if ($result === false) {
            return new ViewModel(array(
                'messages'  => array(),
                'loginForm' => $form,
            ));
        }
        else if (!$result->isValid()) {
            return new ViewModel(array(
                'messages'  => $result->getMessages(),
                'loginForm' => $form,
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
        // Get manager
        $manager = $this->getUserManager();
        
        // Perform logout
        $manager->logout();
        
        // Redirect
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
        
        // Get user manager
        $userManager = $this->getUserManager();
        
        // Get form
        $form = $userManager->getSignupForm();
        
        // Return view, iff PRG is GET request
        if ($prg === false) {
            return new ViewModel(array(
                'signupForm' => $form,
            ));
        }
        
        // Perform registration
        $user = $userManager->createUser($prg);
        
        // Return view, iff user is not valid
        if ($user === false) {
            return new ViewModel(array(
                'signupForm' => $form,
            ));
        }
        
        // Get confirmation manager
        $confirmationManager = $this->getConfirmationManager();
        
        // Create confirmation
        $confirmation = $confirmationManager->createConfirmation($user, $this->getRequest());
        
        // Send confirmation message
        $confirmationManager->sendConfirmationMessage($user, $confirmation);
        
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
        // Redirect, iff user has identity
        if ($this->user()->hasIdentity()) {
            return $this->redirect()->toRoute('home');
        }
        
        // Get confirmation manager
        $confirmationManager = $this->getConfirmationManager();
        
        // Get confirmation mapper
        $confirmationMapper = $confirmationManager->getConfirmationMapper();
        
        // Get confirmation
        $confirmation = $confirmationMapper->selectRow(array(
            'id'            => $this->params()->fromRoute('id'),
            'request_token' => $this->params()->fromRoute('token'),
            'is_confirmed'  => false,
        ));
        
        // Return not found, iff confirmation is empty
        if (empty($confirmation)) {
            return $this->notFoundAction();
        }
        
        // Get user manager
        $userManager = $this->getUserManager();
        
        // Get user mapper
        $userMapper = $userManager->getUserMapper();
        
        // Get user
        $user = $userMapper->selectRowById($confirmation->getUserId());
        
        // Return not found, iff user is empty
        if (empty($user)) {
            return $this->notFoundAction();
        }
        
        // Process confirmation
        $confirmationManager->processConfirmation($user, $confirmation);
        
        // Create view
        $view = new ViewModel();
        
        // Set template
        $view->setTemplate('user/index/confirm');
        
        // Return view
        return $view;
    }
    
    /**
     * Return the confirmation manager.
     * 
     * @return \User\Manager\ConfirmationManagerInterface
     */
    public function getConfirmationManager()
    {
        if ($this->confirmationManager === null) {
            // Set confirmation manager
            $this->confirmationManager = $this->getServiceLocator()->get('user.manager.confirmation');
        }
        
        return $this->confirmationManager;
    }
    
    /**
     * Return the user manager.
     * 
     * @return \User\Manager\UserManagerInterface
     */
    public function getUserManager()
    {
        if ($this->userManager === null) {
            // Set user manager
            $this->userManager = $this->getServiceLocator()->get('user.manager.user');
        }
        
        return $this->userManager;
    }
}