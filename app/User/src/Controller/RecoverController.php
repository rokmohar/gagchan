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
class RecoverController extends AbstractActionController
{
    /**
     * @var \User\Manager\RecoverManagerInterface
     */
    protected $recoverManager;
    
    /**
     * @var \User\Manager\UserManagerInterface
     */
    protected $userManager;
    
    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function requestAction()
    {
        // Redirect, iff user has identity
        if ($this->user()->hasIdentity()) {
            return $this->redirect()->toRoute('home');
        }
        
        // Get PRG
        $prg = $this->prg();
        
        // Redirect, iff PRG is reponse
        if ($prg instanceof Reponse) {
            return $prg;
        }
        
        // Get recover manager
        $recoverManager = $this->getRecoverManager();
        
        // Get email form
        $emailForm = $recoverManager->getEmailForm();
        
        // Return view, iff PRG is GET request
        if ($prg === false) {
            return new ViewModel(array(
                'recoverForm' => $emailForm,
            ));
        }
        
        // Get user manager
        $userManager = $this->getUserManager();
        
        // Post email form
        $user = $userManager->findByEmail($prg);
        
        //Return view, iff form is invalid
        if ($user === false) {
            return new ViewModel(array(
                'recoverForm' => $emailForm,
            ));
        }
        
        // Create recover
        $recover = $recoverManager->createRecover($user, $this->getRequest());
        
        // Send recover message
        $recoverManager->sendRecoverMessage($user, $recover);
        
        // Create view
        $view = new ViewModel(array(
            'recover' => $recover,
            'user'    => $user,
        ));
        
        // Set template
        $view->setTemplate('user/recover/request_success');
        
        // Return view
        return $view;
    }
    
    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function resetAction()
    {
        // Redirect, iff user has identity
        if ($this->user()->hasIdentity()) {
            return $this->redirect()->toRoute('home');
        }
        
        // Get recover manager
        $recoverManager = $this->getRecoverManager();
        
        // Get recover mapper
        $recoverMapper = $recoverManager->getRecoverMapper();
        
        // Get recover
        $recover = $recoverMapper->selectRow(array(
            'id'           => $this->params()->fromRoute('id'),
            'token'        => $this->params()->fromRoute('token'),
            'is_recovered' => false,
        ));
        
        // Return not found, iff recover is empty
        if (empty($recover)) {
            return $this->notFoundAction();
        }
        
        // Get PRG
        $prg = $this->prg();
        
        // Redirect, iff PRG is reponse
        if ($prg instanceof Response) {
            return $prg;
        }
        
        // Get user manager
        $userManager = $this->getUserManager();
        
        // Get password form
        $passwordForm = $userManager->getPasswordForm();
        
        // Return view, iff PRG is GET request
        if ($prg === false) {
            return new ViewModel(array(
                'passwordForm' => $passwordForm,
            ));
        }
        
        // Post password form
        $result = $userManager->postPassword($prg);
        
        // Return view, iff form data is not valid
        if ($result === false) {
            return new ViewModel(array(
                'passwordForm' => $passwordForm,
            ));
        }
        
        // Get user mapper
        $userMapper = $this->getUserMapper();
        
        // Get user
        $user = $userMapper->selectRowById($recover->getUserId());
        
        // Return not found, iff user is empty
        if (empty($user)) {
            return $this->notFoundAction();
        }
        
        // Process recovery
        $recoverManager->processRecover($user, $recover);
        
        // Update user
        $userManager->updateUser($user, $result, true);
        
        // Create view
        $view = new ViewModel(array(
            'user'    => $user,
            'recover' => $recover,
        ));
        
        // Set template
        $view->setTemplate('user/recover/reset_success');
        
        // Return view
        return $view;
    }
    
    /**
     * Return the recover manager.
     * 
     * @return \User\Manager\RecoverManagerInterface
     */
    public function getRecoverManager()
    {
        if ($this->recoverManager === null) {
            // Set recover manager
            $this->recoverManager = $this->getServiceLocator()->get('user.manager.recover');
        }
        
        return $this->recoverManager;
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