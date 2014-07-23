<?php

namespace OAuth\Controller;

use Zend\Mvc\Controller\AbstractActionController;

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
        if ($this->user()->hasIdentity() === true) {
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
        if ($hybridAuth->isConnectedWith($provider) === false) {
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
        if ($result->isValid() === false) {
            // Redirect to route
            return $this->redirect()->toRoute('login');
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
}