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
     * @var \User\Form\AccountSettingsForm
     */
    protected $accountSettingsForm;
    
    /**
     * @var \OAuth\Mapper\OAuthMapperInterface
     */
    protected $oauthMapper;
    
    /**
     * @var \User\Form\PasswordSettingsForm
     */
    protected $passwordSettingsForm;
    
    /**
     * @var \User\Mapper\UserMapperInterface
     */
    protected $userMapper;
    
    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function accountAction()
    {
        // Check if user does not have identity
        if (!$this->user()->hasIdentity()) {
            // Redirect to route
            return $this->redirect()->toRoute('login');
        }
        
        // Get user
        $user = $this->user()->getIdentity();
        
        // Get PRG
        $prg = $this->prg();
        
        // Check if PRG is response
        if ($prg instanceof Response) {
            // Return redirect
            return $prg;
        }
        
        // Get flash messenger
        $fm = $this->flashMessenger();
        $fm->setNamespace('user.settings.index');
        
        // Get form
        $settingsForm = $this->getAccountSettingsForm();
        $settingsForm->bind($user);
        
        // Check if PRG is GET
        if ($prg === false) {
            // Return view
            return new ViewModel(array(
                'messages'     => $fm->getMessages(),
                'settingsForm' => $settingsForm,
            ));
        }
        
        // Set data
        $settingsForm->setData(array_merge($prg, array(
            'id' => $user->getId(),
        )));
        
        // Check if form is not valid
        if (!$settingsForm->isValid()) {
            // Return view
            return new ViewModel(array(
                'messages'     => array(),
                'settingsForm' => $settingsForm,
            ));
        }
        
        // Update user
        $this->getUserMapper()->updateRow($user);
        
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
        // Check if user does not have identity
        if (!$this->user()->hasIdentity()) {
            // Redirect to route
            return $this->redirect()->toRoute('login');
        }
        
        // Get PRG
        $prg = $this->prg();
        
        // Check if PRG is response
        if ($prg instanceof Response) {
            // Return response
            return $prg;
        }
        
        // Get flash messenger
        $fm = $this->flashMessenger();
        $fm->setNamespace('user.settings.password');
        
        // Get form
        $settingsForm = $this->getPasswordSettingsForm();
        
        // Check if PRG is GET
        if ($prg === false) {
            // Return view
            return new ViewModel(array(
                'messages'     => $fm->getMessages(),
                'settingsForm' => $settingsForm,
            ));
        }
        
        // Bind entity prototype
        $settingsForm->bind(new \User\Entity\UserEntity());
        
        // Set data
        $settingsForm->setData($prg);
        
        // Check if form is not valid
        if (!$settingsForm->isValid()) {
            // Return view
            return new ViewModel(array(
                'messages'     => array(),
                'settingsForm' => $settingsForm,
            ));
        }
        
        // Get posted data
        $data = $settingsForm->getData();
        
        // Get user
        $user = $this->user()->getIdentity();
        
        // Encryption service
        $crypt = new Bcrypt(array(
            'cost' => 14,
        ));
        
        // Encrypt password
        $user->setPassword(
            $crypt->create($data->getPassword())
        );
        
        // Update user
        $this->getUserMapper()->updateRow($user);
        
        // Add message
        $fm->addMessage('Password is successfully updated.');
        
        // Redirect to route
        return $this->redirect()->toRoute('settings/password');
    }
    
    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function socialAction()
    {
        // Check if user does not have identity
        if (!$this->user()->hasIdentity()) {
            // Redirect to route
            return $this->redirect()->toRoute('login');
        }
        
        // Get flash messenger
        $fm = $this->flashMessenger();
        $fm->setNamespace('user.settings.index');
        
        // Get user
        $user = $this->user()->getIdentity();
        
        // Get OAuth mapper
        $oauthMapper = $this->getOAuthMapper();
        
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
     * Return the account settings form.
     * 
     * @return \User\Form\AccountSettingsForm
     */
    public function getAccountSettingsForm()
    {
        if ($this->accountSettingsForm === null) {
            return $this->accountSettingsForm = $this->getServiceLocator()->get(
                'user.form.account'
            );
        }
        
        return $this->accountSettingsForm;
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
     * Return the password settings form.
     * 
     * @return \User\Form\PasswordSettingsForm
     */
    public function getPasswordSettingsForm()
    {
        if ($this->passwordSettingsForm === null) {
            return $this->passwordSettingsForm = $this->getServiceLocator()->get(
                'user.form.password'
            );
        }
        
        return $this->passwordSettingsForm;
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