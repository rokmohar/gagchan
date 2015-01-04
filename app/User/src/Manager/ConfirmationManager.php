<?php

namespace User\Manager;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\RequestInterface;

use User\Entity\ConfirmationEntityInterface;
use User\Entity\UserEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class ConfirmationManager implements ConfirmationManagerInterface, ServiceLocatorAwareInterface
{
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
     * @var \User\Mapper\UserMapperInterface
     */
    protected $userMapper;
    
    /**
     * @var \User\Options\UserOptions
     */
    protected $userOptions;
    
    /**
     * {@inheritDoc}
     */
    public function createConfirmation(UserEntityInterface $user, RequestInterface $request)
    {
        // Return false, iff state is not unconfirmed
        if ($user->getState() !== UserEntityInterface::STATE_UNCONFIRMED) {
            return false;
        }
        
        // Get class
        $class = $this->getUserOptions()->getConfirmationEntityClass();
        
        // Create confirmation
        $confirmation = new $class;
        
        // Set confirmation data
        $confirmation
            ->setUserId($user->getId())
            ->setEmail($user->getEmail())
            ->setRemoteAddress($request->getServer('REMOTE_ADDR'))
            ->setRequestAt(new \DateTime())
            ->setRequestToken($this->generateToken())
            ->setConfirmedAt(null)
            ->setIsConfirmed(false)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime())
        ;
        
        // Get confirmation mapper
        $confirmationMapper = $this->getConfirmationMapper();
        
        // Insert row
        $confirmationMapper->insertRow($confirmation);
        
        // Return confirmation
        return $confirmation;
    }
    
    /**
     * {@inheritDoc}
     */
    public function processConfirmation(UserEntityInterface $user, ConfirmationEntityInterface $confirmation)
    {
        // Return false, iff state is not unconfirmed
        if ($user->getState() !== UserEntityInterface::STATE_UNCONFIRMED) {
            return false;
        }
        
        // Return false, iff confirmation is confirmed
        if ($confirmation->isConfirmed() === true) {
            return false;
        }
        
        // Set confirmation data
        $confirmation
            ->setConfirmedAt(new \DateTime())
            ->setIsConfirmed(true)
        ;
        
        // Get confirmation mapper
        $confirmationMapper = $this->getConfirmationMapper();
        
        // Update row
        $confirmationMapper->updateRow($confirmation);
        
        // Set user data
        /*$user
            ->setState(UserEntityInterface::STATE_CONFIRMED)
        ;*/
        
        // Get user mapper
        //$userMapper = $this->getUserMapper();
        
        // Update row
        //$userMapper->updateRow($user);
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
     * {@inheritDoc}
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
    public function getUserMapper()
    {
        if ($this->userMapper === null) {
            // Set user mapper
            $this->userMapper = $this->getServiceLocator()->get('user.mapper.user');
        }
        
        return $this->userMapper;
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