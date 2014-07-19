<?php

namespace User\Controller;

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
    public function indexAction()
    {
        // Check if user does not have identity
        if ($this->user()->hasIdentity() === false) {
            // Redirect to route
            return $this->redirect()->toRoute('login');
        }
        
        // Get request
        $request = $this->getRequest();
        
        // Get form
        $settingsForm = $this->getAccountSettingsForm();
        
        // Check if page is not posted
        if ($request->isPost() === false) {
            // Return view
            return new ViewModel(array(
                'settingsForm' => $settingsForm,
            ));
        }
        
        // Bind entity prototype
        $settingsForm->bind(new \User\Entity\UserEntity());
        
        // Set data
        $settingsForm->setData($request->getPost());
        
        // Check if form is not valid
        if ($settingsForm->isValid() === false) {
            // Return view
            return new ViewModel(array(
                'settingsForm' => $settingsForm,
            ));
        }
        
        die("POSTED");
    }
    
    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function passwordAction()
    {
        // Check if user does not have identity
        if ($this->user()->hasIdentity() === false) {
            // Redirect to route
            return $this->redirect()->toRoute('login');
        }
        
        // Get request
        $request = $this->getRequest();
        
        // Get form
        $settingsForm = $this->getPasswordSettingsForm();
        
        // Check if page is not posted
        if ($request->isPost() === false) {
            // Return view
            return new ViewModel(array(
                'settingsForm' => $settingsForm,
            ));
        }
        
        // Bind entity prototype
        $settingsForm->bind(new \User\Entity\UserEntity());
        
        // Set data
        $settingsForm->setData($request->getPost());
        
        // Check if form is not valid
        if ($settingsForm->isValid() === false) {
            // Return view
            return new ViewModel(array(
                'settingsForm' => $settingsForm,
            ));
        }
        
        die("POSTED");
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
                'user.form.account_settings'
            );
        }
        
        return $this->accountSettingsForm;
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
                'user.form.password_settings'
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