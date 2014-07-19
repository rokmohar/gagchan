<?php

namespace User\Controller;

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
            // @todo: remove for production
            var_dump($loginForm->getMessages()); die();
            
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
}