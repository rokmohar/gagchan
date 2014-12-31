<?php

namespace User\Manager;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use User\Entity\RecoverEntityInterface;
use User\Entity\UserEntityInterface;

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
     * @var \User\Form\Recover\RecoverFormInterface
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
        // Get form
        $form = $this->getRecoverForm();
        
        // Get entity class
        $class = $this->getUserOptions()->getRecoverEntityClass();
        
        // Bind entity class
        $form->bind(new $class);
        
        // Set form data
        $form->setData($data);
        
        // Check if form data is valid
        if ($form->isValid()) {
            // Get form data
            $data = $form->getData();

            // Get mapper
            $mapper = $this->getRecoverMapper();

            // Insert row
            return $mapper->insertRow($data);
        }
        
        return false;
    }
    
    /**
     * {@inheritDoc}
     */
    public function updateRecover(RecoverEntityInterface $recover, array $data)
    {
        // Get form
        $form = $this->getRecoverForm();
        
        // Bind entity class
        $form->bind($recover);
        
        // Set form data
        $form->setData($data);
        
        // Check if form data is valid
        if ($form->isValid()) {
            // Get form data
            $data = $form->getData();

            // Get mapper
            $mapper = $this->getRecoverMapper();

            // Update row
            return $mapper->updateRow($data);
        }
        
        return false;
    }
    
    /**
     * {@inheritDoc}
     */
    public function sendRecoverMessage(UserEntityInterface $user, RecoverEntityInterface $recover)
    {
        // Get mailer
        $mailer = $this->getMailer();
        
        // Send recovery message
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
            // Get mailer
            $this->mailer = $this->getServiceLocator()->get('user.mailer.amazon');
        }
        
        return $this->mailer;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getRecoverForm()
    {
        if ($this->recoverForm === null) {
            // Get recover request form
            $this->recoverForm = $this->getServiceLocator()->get('user.form.recover.request');
        }
        
        return $this->recoverForm;
    }

    /**
     * {@inheritDoc}
     */
    public function getRecoverMapper()
    {
        if ($this->recoverMapper === null) {
            // Get recover mapper
            $this->recoverMapper = $this->getServiceLocator()->get('user.mapper.recover');
        }
        
        return $this->recoverMapper;
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
            // Get user options
            $this->userOptions = $this->getServiceLocator()->get('user.options.user');
        }
        
        return $this->userOptions;
    }
}