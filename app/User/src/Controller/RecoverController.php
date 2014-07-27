<?php

namespace User\Controller;

use Zend\Crypt\Password\Bcrypt;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Core\Utils\TokenGenerator;

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
     * @var \User\Mapper\RecoverMapperInterface
     */
    protected $recoverMapper;
    
    /**
     * @var \User\Form\PasswordForm
     */
    protected $passwordForm;
    
    /**
     * @var \User\Mapper\UserMapperInterface
     */
    protected $userMapper;
    
    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function requestAction()
    {
        // Check if user has identity
        if ($this->user()->hasIdentity()) {
            // Redirect to route
            return $this->redirect()->toRoute('home');
        }
        
        // Get PRG
        $prg = $this->prg();
        
        // Check if PRG is reponse
        if ($prg instanceof Reponse) {
            // Return response
            return $prg;
        }
        
        // Get form
        $recoverForm = $this->getRecoverForm();
        
        // Check if PRG is GET
        if ($prg === false) {
            // Return view
            return new ViewModel(array(
                'recoverForm' => $recoverForm,
            ));
        }
        
        // Set entity prototype
        $recoverForm->bind(new \User\Entity\UserEntity());

        // Set posted data
        $recoverForm->setData($prg);

        // Check if form is not valid
        if (!$recoverForm->isValid()) {
            // Return view
            return new ViewModel(array(
                'recoverForm' => $recoverForm,
            ));
        }
        
        // Get data
        $data = $recoverForm->getData();
        
        // Get user
        $user = $this->getUserMapper()->selectRowByEmail($data->getEmail());
        
        // Create class
        $recover = new \User\Entity\RecoverEntity();
        
        $recover->setUserId($user->getId());
        $recover->setEmail($user->getEmail());
        $recover->setRemoteAddress(
            $this->getRequest()->getServer('REMOTE_ADDR')
        );
        $recover->setRequestAt(new \DateTime());
        $recover->setRequestToken($this->generateToken());
        $recover->setRecoveredAt();
        $recover->setIsRecovered(false);
        
        // Get recover mapper
        $this->getRecoverMapper()->insertRow($recover);
        
        // Send message
        $this->getMailer()->sendRecoverMessage($user, $recover);
        
        // Create view
        $view = new ViewModel(array(
            'user'    => $user,
            'recover' => $recover,
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
        // Check if user has identity
        if ($this->user()->hasIdentity()) {
            // Redirect to route
            return $this->redirect()->toRoute('home');
        }
        
        // Get recover mapper
        $recoverMapper = $this->getRecoverMapper();
        
        // Get recover
        $recover = $recoverMapper->selectNotConfirmed(
            $this->params()->fromRoute('id'),
            $this->params()->fromRoute('token')
        );
        
        // Check if recover is empty
        if (empty($recover)) {
            // Recover not found
            return $this->notFoundAction();
        }
        
        // Get PRG
        $prg = $this->prg();
        
        // Check if PRG is response
        if ($prg instanceof Response) {
            // Return response
            return $prg;
        }
        
        // Get form
        $passwordForm = $this->getPasswordForm();
        
        // Check if PRG is GET
        if ($prg === false) {
            // Return view
            return new ViewModel(array(
                'passwordForm' => $passwordForm,
            ));
        }
        
        // Set data
        $passwordForm->setData($prg);
        
        // Check if form is not valid
        if (!$passwordForm->isValid()) {
            // Return view
            return new ViewModel(array(
                'passwordForm' => $passwordForm,
            ));
        }
        
        // Get user mapper
        $userMapper = $this->getUserMapper();
        
        // Get user
        $user = $this->getUserMapper()->selectRowById($recover->getUserId());
        
        // Get crypt
        $crypt = new Bcrypt(array(
            'cost' => 14,
        ));
        
        // Set password
        $user->setPassword($crypt->create(
            $passwordForm->get('password')->getValue()
        ));
        
        // Update user
        $userMapper->updateRow($user);
        
        // Set as recovered
        $recover->setRecoveredAt(new \DateTime());
        $recover->setIsRecovered(true);
        
        // Update recover
        $recoverMapper->updateRow($recover);
        
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
     * Generate a random token.
     * 
     * @return string
     */
    public function generateToken()
    {
        // Get token generator
        $generator = new TokenGenerator();
        
        // Generate token
        return $generator->getToken(32);
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
     * Return the password form.
     * 
     * @return \User\Form\PasswordForm
     */
    public function getPasswordForm()
    {
        if ($this->passwordForm === null) {
            return $this->passwordForm = $this->getServiceLocator()->get(
                'user.form.password'
            );
        }
        
        return $this->passwordForm;
    }
    
    /**
     * Return the recover mapper.
     * 
     * @return \User\Mapper\RecoverMapperInterface
     */
    public function getRecoverMapper()
    {
        if ($this->recoverMapper === null) {
            return $this->recoverMapper = $this->getServiceLocator()->get(
                'user.mapper.recover'
            );
        }
        
        return $this->recoverMapper;
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