<?php

namespace User\Manager;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use User\Form\RecoverFormInterface;
use User\Mailer\MailerInterface;
use User\Mapper\RecoverMapperInterface;
use User\Options\UserOptionsInterface;

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
     * @var \User\Options\UserOptionsInterface
     */
    protected $userOptions;
    
    /**
     * {@inheritDoc}
     */
    public function createRecover(array $data)
    {
        // Get recover form
        $recoverForm = $this->getRecoverForm();
        
        // Get recover class
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
        
        // Get recover mapper
        $recoverMapper = $this->getRecoverMapper();
        
        // Insert a row
        return $recoverMapper->insertRow($data);
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
     * {@inheritDoc}
     */
    public function getMailer()
    {
        
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
        
    }

    /**
     * {@inheritDoc}
     */
    public function setRecoverForm(RecoverFormInterface $recoverForm)
    {
        
    }

    /**
     * {@inheritDoc}
     */
    public function getRecoverMapper()
    {
        
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
        
    }

    /**
     * {@inheritDoc}
     */
    public function setUserOptions(UserOptionsInterface $userOptions)
    {
        $this->userOptions = $userOptions;
        
        return $this;
    }
}