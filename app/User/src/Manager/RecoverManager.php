<?php

namespace User\Manager;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use User\Form\RecoverFormInterface;
use User\Mailer\MailerInterface;
use User\Mapper\RecoverMapperInterface;
use User\Options\UserOptions;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class RecoverManager implements RecoverManagerInterface, ServiceLocatorAwareInterface
{
    /**
     * @var \User\Mailer\MailerInterface
     */
    protected $mailer;
    
    /**
     * @var \User\Form\RecoverFormInterface
     */
    protected $recoverForm;
    
    /**
     * @var \User\Mapper\RecoverMapperInterface
     */
    protected $recoverMapper;
    
    /**
     * @var \Zend\ServiceManager\ServiceLocatorInterface
     */
    protected $serviceLocator;
    
    /**
     * @var \User\Options\UserOptions
     */
    protected $userOptions;
    
    /**
     * {@inheritDoc}
     */
    public function createRecover(array $data)
    {
        // Get recover form
        $recoverForm = $this->getRecoverForm();
        
        // Get class
        $recoverClass = $this->getUserOptions()->getRecoverEntityClass();
        
        // Bind entity
        $recoverForm->bind(new $recoverClass);
        
        // Set data
        $recoverForm->setData($data);
        
        // Check if data is valid
        if (!$recoverForm->isValid()) {
            // Data is not valid
            return false;
        }
        
        // Get data
        $data = $recoverForm->getData();
        
        var_dump($data); die();
        
        // Get recover mapper
        $recoverMapper = $this->getRecoverMapper();
        
        // Insert a row
        return $recoverMapper->insertRow($data);
    }
    
    /**
     * {@inheritDoc}
     */
    public function updateRecover(array $data)
    {
        // Get recover form
        $recoverForm = $this->getRecoverForm();
        
        // Get class
        //$recoverClass = $this->getUserOptions()->getRecoverEntityClass();
        
        // Bind entity
        //$recoverForm->bind(new $recoverClass);
        
        // Set data
        $recoverForm->setData($data);
        
        // Check if data is valid
        if (!$recoverForm->isValid()) {
            // Data is not valid
            return false;
        }
        
        // Get data
        $data = $recoverForm->getData();
        
        var_dump($data); die();
        
        // Get recover mapper
        $recoverMapper = $this->getRecoverMapper();
        
        // Insert a row
        return $recoverMapper->updateRow($data);
    }
    
    /**
     * {@inheritDoc}
     */
    public function sendRecoverMessage(
        UserEntityInterface $user,
        RecoverEntityInterface $recover
    ) {
        // Get mailer
        $mailer = $this->getMailer();
        
        // Send recover message
        return $mailer->sendRecoverMessage($user, $recover);
        
    }
    
    /**
     * Generate random token.
     * 
     * @return string
     */
    public function generateToken()
    {
        // Get token generator
        $generator = \Core\Utils\TokenGenerator::getInstance();
        
        // Generate token
        return $generator->getToken(32);
    }
    
    /**
     * {@inheritDoc}
     */
    public function getMailer()
    {
        if ($this->mailer === null) {
            $this->setMailer($this->getServiceLocator()->get('user.mailer.amazon'));
        }
        
        return $this->mailer;
    }
    
    /**
     * {@inheritDoc}
     */
    public function setMailer(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getRecoverForm()
    {
        if ($this->recoverForm === null) {
            $this->setRecoverForm($this->getServiceLocator()->get('user.form.recover'));
        }
        
        return $this->recoverForm;
    }

    /**
     * {@inheritDoc}
     */
    public function setRecoverForm(RecoverFormInterface $recoverForm)
    {
        $this->recoverForm = $recoverForm;
        
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getRecoverMapper()
    {
        if ($this->recoverMapper === null) {
            $this->setRecoverMapper($this->getServiceLocator()->get('user.mapper.recover'));
        }
        
        return $this->recoverMapper;
    }

    /**
     * {@inheritDoc}
     */
    public function setRecoverMapper(RecoverMapperInterface $recoverMapper)
    {
        $this->recoverMapper = $recoverMapper;
        
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * {@inheritDoc}
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUserOptions()
    {
        if ($this->userOptions === null) {
            $this->setUserOptions($this->getServiceLocator()->get('user.options.user'));
        }
        
        return $this->userOptions;
    }

    /**
     * {@inheritDoc}
     */
    public function setUserOptions(UserOptions $userOptions)
    {
        $this->userOptions = $userOptions;
        
        return $this;
    }
}