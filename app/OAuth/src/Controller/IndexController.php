<?php

namespace OAuth\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use OAuth\Manager\Exception\InvalidProviderException;

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
     * @var \OAuth\Manager\OAuthManagerInterface
     */
    protected $oauthManager;
    
    /**
     * @var \User\Manager\UserManagerInterface
     */
    protected $userManager;
    
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
        
        // Check if provider is disabled
        if (!array_key_exists($provider, $hybridAuth->getProviders())) {
            // Page not found
            return $this->notFoundAction();
        }
        
        // Check if provider is not connected
        if (!$hybridAuth->isConnectedWith($provider)) {
            // Authenticate provider
            $hybridAuth->authenticate($provider, array(
                'hauth_return_to' => $this->url()->fromRoute('oauth', array(
                    'provider' => $provider,
                )),
            ));
        }
        
        // Get user manager
        $userManager = $this->getUserManager();
        
        // Perform an authentication
        $result = $userManager->authenticate(array(
            'provider' => $provider,
        ));
        
        // Check if authentication failed
        if (!$result->isValid()) {
            // @todo: add error message
            
            // Redirect to route
            return $this->redirect()->toRoute('login');
        }
        
        // Redirect to route
        return $this->redirect()->toRoute('home');
    }
    
    /**
     * @return mixed
     */
    public function connectAction()
    {
        // Check if user does not have identity
        if (!$this->user()->hasIdentity()) {
            // Redirect to route
            return $this->redirect()->toRoute('login');
        }
        
        try {
            // Connect to provider
            $this->getOAuthManager()->connect(
                $this->user()->getIdentity(),
                $this->params()->fromRoute('provider')
            );
        }
        catch (InvalidProviderException $e) {
            // Provider not found
            return $this->notFoundAction();
        }
        
        // Redirect to route
        return $this->redirect()->toRoute('settings/social');
    }
    
    /**
     * @return mixed
     */
    public function disconnectAction()
    {
        // Check if user does not have identity
        if (!$this->user()->hasIdentity()) {
            // Redirect to route
            return $this->redirect()->toRoute('login');
        }
        
        try {
            // Disconnect to provider
            $this->getOAuthManager()->disconnect(
                $this->user()->getIdentity(),
                $this->params()->fromRoute('provider')
            );
        }
        catch (InvalidProviderException $e) {
            // Provider not found
            return $this->notFoundAction();
        }
        
        // Redirect to route
        return $this->redirect()->toRoute('settings/social');
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
     * Return the OAuth mapper.
     * 
     * @return \OAuth\Manager\OAuthManagerInterface
     */
    public function getOAuthManager()
    {
        if ($this->oauthManager === null) {
            return $this->oauthManager = $this->getServiceLocator()->get(
                'oauth.manager.oauth'
            );
        }
        
        return $this->oauthManager;
    }
    
    /**
     * Return the user manager.
     * 
     * @return \User\Manager\UserManagerInterface
     */
    public function getUserManager()
    {
        if ($this->userManager === null) {
            return $this->userManager = $this->getServiceLocator()->get(
                'user.manager.user'
            );
        }
        
        return $this->userManager;
    }
}