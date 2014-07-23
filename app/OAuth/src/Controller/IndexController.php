<?php

namespace OAuth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class IndexController extends AbstractActionController
{
    /**
     * @var \Hybrid_Auth
     */
    protected $hybridAuth;
    
    /**
     * @var \User\Form\LoginForm
     */
    protected $loginForm;
    
    /**
     * @return mixed
     */
    public function hybridAuthAction()
    {
        \Hybrid_Endpoint::process();
        
        // Redirect to route
        return $this->redirect()->toRoute('login');
    }
    
    /**
     * @return mixed
     */
    public function loginAction()
    {
        // Check if user has identity
        if ($this->user()->hasIdentity()) {
            // Redirect to route
            return $this->redirect()->toRoute('home');
        }
        
        // Get provider
        $provider = $this->params()->fromRoute('provider');
        
        // Get hybrid auth
        $hybridAuth = $this->getHybridAuth();
        
        // Check if provider is not enabled
        if (!array_key_exists($provider, $hybridAuth->getProviders())) {
            // Page not found
            return $this->notFoundAction();
        }
        
        // Check if adapter is connected with provider
        if (!$hybridAuth->isConnectedWith($provider)) {
            // Authenticate adapter with provider
            $hybridAuth->authenticate($provider, array(
                'hauth_return_to' => $this->url()->fromRoute('oauth', array(
                    'provider' => $provider,
                )),
            ));
        }
        
        // Get auth service
        $authService = $this->user()->getAuthService();
        
        // Add param
        $authService->addParam('provider', $provider);
        
        // Perform authentication
        $result = $authService->authenticate();
        
        // Check if authentication is not valid
        if (!$result->isValid()) {
            // Get form
            $loginForm = $this->getLoginForm();

            // Set messages
            $loginForm->get('email')->setMessages($result->getMessages());
            
            // Create view
            $view = new ViewModel(array(
                'loginForm' => $loginForm,
            ));
            
            // Set template
            $view->setTemplate('user/index/login');
            
            // Return view
            return $view;
        }
        
        // Redirect to route
        return $this->redirect()->toRoute('home');
    }
    
    /**
     * @return \Hybrid_Auth
     */
    public function getHybridAuth()
    {
        if ($this->hybridAuth === null) {
            return $this->hybridAuth = $this->getServiceLocator()->get(
                'oauth.hybridauth'
            );
        }
        
        return $this->hybridAuth;
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