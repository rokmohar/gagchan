<?php

namespace User\Manager;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use User\Entity\ConfirmationEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class ConfirmationManager implements ConfirmationManagerInterface, ServiceLocatorAwareInterface
{
    /**
     * @var \User\Mailer\MailerInterface
     */
    protected $userMailer;
    
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
     * @var \User\Options\UserOptions
     */
    protected $userOptions;
    
    /**
     * {@inheritDoc}
     */
    public function createConfirmation(array $data)
    {
        // Get confirmation form
        $confirmationForm = $this->getConfirmationForm();
        
        // Get confirmation entity
        $confirmationClass = $this->getUserOptions()->getConfirmationEntityClass();
        
        // Bind confirmation entity
        $confirmationForm->bind(new $confirmationClass);
        
        // Set form data
        $confirmationForm->setData($data);
        
        // Return false, iff data is not valid
        if (!$confirmationForm->isValid()) {
            return false;
        }
        
        // Get form data
        $data = $confirmationForm->getData();
        
        // Get confirmation mapper
        $confirmationMapper = $this->getConfirmationMapper();
        
        // Insert a row
        $confirmationMapper->insertRow($data);
        
        // Return data
        return $data;
    }
    /**
     * {@inheritDoc}
     */
    public function updateConfirmation(ConfirmationEntityInterface $confirmation, array $data)
    {
        // Get confirmation form
        $confirmationForm = $this->getConfirmationForm();
        
        // Bind confirmation entity
        $confirmationForm->bind($confirmation);
        
        // Set form data
        $confirmationForm->setData($data);
        
        // Return false, iff data is not valid
        if (!$confirmationForm->isValid()) {
            return false;
        }
        
        // Get form data
        $data = $confirmationForm->getData();
        
        var_dump($data); die();
        
        // Get confirmation mapper
        $confirmationMapper = $this->getConfirmationMapper();
        
        // Insert a row
        $confirmationMapper->updateRow($data);
        
        // Return data
        return $data;
    }
    
    /**
     * {@inheritDoc}
     */
    public function sendConfirmationMessage(UserEntityInterface $user, ConfirmationEntityInterface $confirmation) {
        // Get user mailer
        $userMailer = $this->getUserMailer();
        
        // Send confirmation message
        return $userMailer->sendConfirmationMessage($user, $confirmation);
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
    public function getUserMailer()
    {
        if ($this->userMailer === null) {
            // Set user mailer
            $this->userMailer = $this->getServiceLocator()->get('user.mailer.amazon');
        }
        
        return $this->userMailer;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getConfirmationForm()
    {
        if ($this->confirmationForm === null) {
            // Set confirmation form
            $this->confirmationForm = $this->getServiceLocator()->get('user.form.confirmation');
        }
        
        return $this->confirmationForm;
    }

    /**
     * {@inheritDoc}
     */
    public function getConfirmationMapper()
    {
        if ($this->confirmationMapper === null) {
            // Set confirmation mapper
            $this->confirmationMapper = $this->getServiceLocator()->get('user.mapper.confirmation');
        }
        
        return $this->confirmationMapper;
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
            // Set user options
            $this->userOptions = $this->getServiceLocator()->get('user.options.user');
        }
        
        return $this->userOptions;
    }
}