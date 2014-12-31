<?php

namespace User\Manager;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use User\Entity\ConfirmationEntityInterface;
use User\Entity\UserEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class ConfirmationManager implements ConfirmationManagerInterface, ServiceLocatorAwareInterface
{
    /**
     * @var \User\Form\ConfirmationFormInterface
     */
    protected $confirmationForm;
    
    /**
     * @var \User\Mapper\ConfirmationMapperInterface
     */
    protected $confirmationMapper;
    
    /**
     * @var \User\Mailer\MailerInterface
     */
    protected $mailer;
    
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
        // Get form
        $form = $this->getConfirmationForm();
        
        // Get entity class
        $class = $this->getUserOptions()->getConfirmationEntityClass();
        
        // Bind entity class
        $form->bind(new $class);
        
        // Set form data
        $form->setData($data);
        
        // Check form data is valid
        if ($form->isValid()) {
            // Get form data
            $data = $form->getData();

            // Get mapper
            $mapper = $this->getConfirmationMapper();

            // Insert row
            $mapper->insertRow($data);

            // Return data
            return $data;
        }
        
        return false;
    }
    /**
     * {@inheritDoc}
     */
    public function updateConfirmation(ConfirmationEntityInterface $confirmation, array $data)
    {
        // Get form
        $form = $this->getConfirmationForm();
        
        // Bind entity class
        $form->bind($confirmation);
        
        // Set form data
        $form->setData($data);
        
        // Check if form data is valid
        if ($form->isValid()) {
            // Get form data
            $data = $form->getData();

            // Get mapper
            $mapper = $this->getConfirmationMapper();

            // Insert row
            $mapper->updateRow($data);

            // Return data
            return $data;
        }
        
        return false;
    }
    
    /**
     * {@inheritDoc}
     */
    public function sendConfirmationMessage(UserEntityInterface $user, ConfirmationEntityInterface $confirmation)
    {
        // Get mailer
        $mailer = $this->getMailer();
        
        // Send confirmation message
        return $mailer->sendConfirmationMessage($user, $confirmation);
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
    public function getMailer()
    {
        if ($this->mailer === null) {
            // Set mailer
            $this->mailer = $this->getServiceLocator()->get('user.mailer.amazon');
        }
        
        return $this->mailer;
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