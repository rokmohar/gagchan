<?php

namespace OAuth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use OAuth\Entity\OAuthEntity;

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
     * @var \OAuth\Mapper\OAuthMapperInterface
     */
    protected $oauthMapper;
    
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
     * @return mixed
     */
    public function connectAction()
    {
        // Check if user does not have identity
        if (!$this->user()->hasIdentity()) {
            // Redirect to route
            return $this->redirect()->toRoute('login');
        }
        
        // Get user
        $user = $this->user()->getIdentity();
        
        // Get provider
        $provider = $this->params()->fromRoute('provider');
        
        // Get OAuth mapper
        $oauthMapper = $this->getOAuthMapper();
        
        // Select row
        $row = $oauthMapper->selectRowByProvider($user->getId(), $provider);
        
        // Check if user is connected
        if (!empty($row)) {
            // Redirect to route
            return $this->redirect()->toRoute('settings/social');
        }
        
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
                'hauth_return_to' => $this->url()->fromRoute('connect', array(
                    'provider' => $provider,
                )),
            ));
        }
        
        // Authenticate provider
        $adapter = $hybridAuth->authenticate($provider);
        
        // Get profile
        $profile = $adapter->getUserProfile();
        
        // Create oauth
        $oauth = new OAuthEntity();
        
        $oauth->setUserId($user->getId());
        $oauth->setProvider($provider);
        $oauth->setProviderId($profile->identifier);
        
        // Insert oauth
        $oauthMapper->insertRow($oauth);
        
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
        
        // Get user
        $user = $this->user()->getIdentity();
        
        // Get provider
        $provider = $this->params()->fromRoute('provider');
        
        // Get OAuth mapper
        $oauthMapper = $this->getOAuthMapper();
        
        // Select row
        $row = $oauthMapper->selectRowByProvider($user->getId(), $provider);
        
        // Check if user is connected
        if (empty($row)) {
            // Redirect to route
            return $this->redirect()->toRoute('settings/social');
        }
        
        // Remove a row
        $oauthMapper->deleteRow($row);
        
        // Get hybrid auth
        $hybridAuth = $this->getHybridAuth();
        
        // Check if provider is connected
        if ($hybridAuth->isConnectedWith($provider)) {
            // Logout provider
            $hybridAuth->getAdapter($provider)->logout();
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
     * Return the OAuth mapper.
     * 
     * @return \OAuth\Mapper\OAuthMapperInterface
     */
    public function getOAuthMapper()
    {
        if ($this->oauthMapper === null) {
            return $this->oauthMapper = $this->getServiceLocator()->get(
                'oauth.mapper.oauth'
            );
        }
        
        return $this->oauthMapper;
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