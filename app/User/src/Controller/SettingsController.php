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
        // Redirect, iff user does not have identity
        if (!$this->user()->hasIdentity()) {
            return $this->redirect()->toRoute('login');
        }
        
        // Get user
        $user = $this->user()->getIdentity();
        
        // Get PRG
        $prg = $this->prg();
        
        // Redirect, iff PRG is response
        if ($prg instanceof Response) {
            return $prg;
        }
        
        // Get flash messenger
        $fm = $this->flashMessenger();
        $fm->setNamespace('user.settings.index');
        
        // Get form
        $settingsForm = $this->getAccountSettingsForm();
        $settingsForm->bind($user);
        
        // Return view, iff PRG is GET request
        if ($prg === false) {
            return new ViewModel(array(
                'messages'     => $fm->getMessages(),
                'settingsForm' => $settingsForm,
            ));
        }
        
        // Set data
        $settingsForm->setData(array_merge($prg, array(
            'id' => $user->getId(),
        )));
        
        // Return view, iff form is not valid
        if (!$settingsForm->isValid()) {
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
        
        // Get form
        $settingsForm = $this->getPasswordSettingsForm();
        
        // Return view, iff PRG is GET request
        if ($prg === false) {
            return new ViewModel(array(
                'messages'     => $fm->getMessages(),
                'settingsForm' => $settingsForm,
            ));
        }
        
        // Bind entity prototype
        $settingsForm->bind(new \User\Entity\UserEntity());
        
        // Set data
        $settingsForm->setData($prg);
        
        // Return view, iff form is not valid
        if (!$settingsForm->isValid()) {
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
     * @return \User\Form\User\UserFormInterface
     */
    public function getAccountForm()
    {
        if ($this->accountForm === null) {
            // Set account form
            $this->accountForm = $this->getServiceLocator()->get('user.form.user.account');
        }
        
        return $this->accountForm;
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
     * @return \User\Form\User\UserFormInterface
     */
    public function getPasswordForm()
    {
        if ($this->passwordForm === null) {
            // Set password form
            $this->passwordForm = $this->getServiceLocator()->get('user.form.user.password');
        }
        
        return $this->passwordForm;
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
}