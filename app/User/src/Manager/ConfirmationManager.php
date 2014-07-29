<?php

namespace User\Manager;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use User\Form\ConfirmationFormInterface;
use User\Mailer\MailerInterface;
use User\Mapper\ConfirmationMapperInterface;
use User\Options\UserOptionsInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class ConfirmationManager implements ConfirmationManagerInterface, ServiceLocatorAwareInterface
{
    /**
     * @var \User\Mailer\MailerInterface
     */
    protected $mailer;
    
    /**
     * @var \User\Form\ConfirmationFormInterface
     */
    protected $confirmationForm;
    
    /**
     * @var \User\Mapper\ConfirmationMapperInterface
     */
    protected $confirmationMapper;
    
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
    public function createConfirmation(array $data)
    {
        // Get confirmation form
        $confirmationForm = $this->getConfirmationForm();
        
        // Get confirmation class
        $confirmationClass = $this->getUserOptions()->getConfirmationEntityClass();
        
        // Bind entity
        $confirmationForm->bind(new $confirmationClass);
        
        // Set data
        $confirmationForm->setData($data);
        
        // Check if data is valid
        if (!$confirmationForm->isValid()) {
            // Data is not valid
            return false;
        }
        
        // Get data
        $data = $confirmationForm->getData();
        
        var_dump($data); die();
        
        // Get confirmation mapper
        $confirmationMapper = $this->getConfirmationMapper();
        
        // Insert a row
        return $confirmationMapper->insertRow($data);
    }
    
    /**
     * {@inheritDoc}
     */
    public function sendConfirmationMessage(
        UserEntityInterface $user,
        ConfirmationEntityInterface $confirmation
    ) {
        // Get mailer
        $mailer = $this->getMailer();
        
        // Send confirmation message
        return $mailer->sendConfirmationMessage($user, $confirmation);
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
    public function getConfirmationForm()
    {
        if ($this->confirmationForm === null) {
            $this->setConfirmationForm($this->getServiceLocator()->get('user.form.confirmation'));
        }
        
        return $this->confirmationForm;
    }

    /**
     * {@inheritDoc}
     */
    public function setConfirmationForm(ConfirmationFormInterface $confirmationForm)
    {
        $this->confirmationForm = $confirmationForm;
        
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getConfirmationMapper()
    {
        if ($this->confirmationMapper === null) {
            $this->setConfirmationMapper($this->getServiceLocator()->get('user.mapper.confirmation'));
        }
        
        return $this->confirmationMapper;
    }

    /**
     * {@inheritDoc}
     */
    public function setConfirmationMapper(ConfirmationMapperInterface $confirmationMapper)
    {
        $this->confirmationMapper = $confirmationMapper;
        
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
    public function setUserOptions(UserOptionsInterface $userOptions)
    {
        $this->userOptions = $userOptions;
        
        return $this;
    }
}