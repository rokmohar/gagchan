<?php

namespace User\Controller;

use Zend\Crypt\Password\Bcrypt;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class SettingsController extends AbstractActionController
{
    /**
     * @var \OAuth\Mapper\OAuthMapperInterface
     */
    protected $oauthMapper;
    
    /**
     * @var \User\Manager\UserManagerInterface
     */
    protected $userManager;
    
    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function accountAction()
    {
        // Redirect, iff user does not have identity
        if (!$this->user()->hasIdentity()) {
            return $this->redirect()->toRoute('login');
        }
        
        // Get PRG
        $prg = $this->prg();
        
        // Redirect, iff PRG is response
        if ($prg instanceof Response) {
            return $prg;
        }
        
        // Get flash messenger
        $fm = $this->flashMessenger();
        $fm->setNamespace('user.settings.index');
        
        // Get user manager
        $userManager = $this->getUserManager();
        
        // Get settings form
        $settingsForm = $userManager->getSettingsForm();
        
        // Return view, iff PRG is GET request
        if ($prg === false) {
            return new ViewModel(array(
                'messages'     => $fm->getMessages(),
                'settingsForm' => $settingsForm,
            ));
        }
        
        // Get user
        $user = $this->user()->getIdentity();
        
        // Post settings form
        $result = $userManager->postSettings(array_merge($prg, array(
            'id' => $user->getId(),
        )));
        
        // Return view, iff form is not valid
        if ($result === false) {
            return new ViewModel(array(
                'messages'     => array(),
                'settingsForm' => $settingsForm,
            ));
        }
        
        // Update user
        $userManager->updateUser($user, $result, false);
        
        // Add message
        $fm->addMessage('Settings are successfully updated.');
        
        // Redirect to route
        return $this->redirect()->toRoute('settings');
    }
    
    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function passwordAction()
    {
        // Redirect, iff user does not have identity
        if (!$this->user()->hasIdentity()) {
            return $this->redirect()->toRoute('login');
        }
        
        // Get PRG
        $prg = $this->prg();
        
        // Redirect, iff PRG is response
        if ($prg instanceof Response) {
            return $prg;
        }
        
        // Get flash messenger
        $fm = $this->flashMessenger();
        $fm->setNamespace('user.settings.password');
        
        // Get user manager
        $userManager = $this->getUserManager();
        
        // Get password form
        $passwordForm = $userManager->getPasswordSettingsForm();
        
        // Return view, iff PRG is GET request
        if ($prg === false) {
            return new ViewModel(array(
                'messages'     => $fm->getMessages(),
                'settingsForm' => $passwordForm,
            ));
        }
        
        // Post password form
        $result = $userManager->postPassword($prg);
        
        // Return view, iff form is not valid
        if ($result === false) {
            return new ViewModel(array(
                'messages'     => array(),
                'settingsForm' => $passwordForm,
            ));
        }
        
        // Get user
        $user = $this->user()->getIdentity();
        
        // Update user
        $userManager->updateUser($user, $result, true);
        
        // Add message
        $fm->addMessage('Password is successfully updated.');
        
        // Redirect
        return $this->redirect()->toRoute('settings/password');
    }
    
    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function socialAction()
    {
        // Redirect, iff user does not have identity
        if (!$this->user()->hasIdentity()) {
            return $this->redirect()->toRoute('login');
        }
        
        // Get flash messenger
        $fm = $this->flashMessenger();
        $fm->setNamespace('user.settings.index');
        
        // Get OAuth mapper
        $oauthMapper = $this->getOAuthMapper();
        
        // Get user
        $user = $this->user()->getIdentity();
        
        // Check connected providers
        $isFacebook = $oauthMapper->selectRowByProvider($user->getId(), 'facebook');
        $isGoogle   = $oauthMapper->selectRowByProvider($user->getId(), 'google');
        
        // Return view
        return new ViewModel(array(
            'messages'   => $fm->getMessages(),
            'isFacebook' => $isFacebook,
            'isGoogle'   => $isGoogle,
        ));
    }
    
    /**
     * @return \OAuth\Mapper\OAuthMapperInterface
     */
    public function getOAuthMapper()
    {
        if ($this->oauthMapper === null) {
            // Set OAuth mapper
            $this->oauthMapper = $this->getServiceLocator()->get('oauth.mapper.oauth');
        }
        
        return $this->oauthMapper;
    }
    
    /**
     * @return \User\Mapper\UserMapperInterface
     */
    public function getUserMapper()
    {
        if ($this->userMapper === null) {
            // Set user mapper
            $this->userMapper = $this->getServiceLocator()->get('user.mapper.user');
        }
        
        return $this->userMapper;
    }
    
    /**
     * Return the user manager.
     * 
     * @return \User\Manager\UserManagerInterface
     */
    public function getUserManager()
    {
        if ($this->userManager === null) {
            // Set user mapper
            $this->userManager = $this->getServiceLocator()->get('user.manager.user');
        }
        
        return $this->userManager;
    }
}