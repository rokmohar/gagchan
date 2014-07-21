<?php

namespace User\Controller;

use Zend\Crypt\Password\Bcrypt;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class RecoverController extends AbstractActionController
{
    /**
     * @var \User\Mailer\MailerInterface
     */
    protected $mailer;
    
    /**
     * @var \User\Form\RecoverForm
     */
    protected $recoverForm;
    
    /**
     * @var \User\Mapper\UserMapperInterface
     */
    protected $userMapper;
    
    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        // Check if user has identity
        if ($this->user()->hasIdentity() === true) {
            // Redirect to route
            return $this->redirect()->toRoute('home');
        }
        
        // Get request
        $request = $this->getRequest();
        
        // Get form
        $recoverForm = $this->getRecoverForm();
        
        // Check if page is not posted
        if ($request->isPost() === false) {
            // Return view
            return new ViewModel(array(
                'recoverForm' => $recoverForm,
            ));
        }
        
        // Set entity prototype
        $recoverForm->bind(new \User\Entity\UserEntity());

        // Set posted data
        $recoverForm->setData($request->getPost());

        // Check if form is not valid
        if ($recoverForm->isValid() === false) {
            // Return view
            return new ViewModel(array(
                'recoverForm' => $recoverForm,
            ));
        }
        
        // Get data
        $data = $recoverForm->getData();
        
        // Get mailer
        $mailer = $this->getMailer();
        
        // Send message
        $mailer->sendRecoverMessage($data);
        
        var_dump($data); die();
    }
    
    /**
     * Return the mailer.
     * 
     * @return \User\Mailer\MailerInterface
     */
    public function getMailer()
    {
        if ($this->mailer === null) {
            return $this->mailer = $this->getServiceLocator()->get(
                'user.mailer.amazon'
            );
        }
        
        return $this->mailer;
    }
    
    /**
     * Return the recover form.
     * 
     * @return \User\Form\RecoverForm
     */
    public function getRecoverForm()
    {
        if ($this->recoverForm === null) {
            return $this->recoverForm = $this->getServiceLocator()->get(
                'user.form.recover'
            );
        }
        
        return $this->recoverForm;
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