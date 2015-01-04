<?php

namespace User\Manager;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\RequestInterface;

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
     * @var \User\Mapper\RecoverMapperInterface
     */
    protected $recoverMapper;
    
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
    public function createRecover(UserEntityInterface $user, RequestInterface $request)
    {
        // Return false, iff account is not confirmed
        if ($user->getState() !== UserEntityInterface::STATE_CONFIRMED) {
            return false;
        }

        // Get class
        $class = $this->getUserOptions()->getRecoverEntityClass();

        // Create recover
        $recover = new $class;

        // Set recover data
        $recover
            ->setUserId($user->getId())
            ->setEmail($user->getEmail())
            ->setRemoteAddress($request->getServer('REMOTE_ADDR'))
            ->setRequestAt(new \DateTime())
            ->setRequestToken($this->generateToken())
            ->setRecoveredAt(null)
            ->setIsRecovered(false)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime())
        ;

        // Get recover mapper
        $recoverMapper = $this->getRecoverMapper();

        // Insert row
        $recoverMapper->insertRow($recover);

        // Return recover
        return $recover;
    }
    
    /**
     * {@inheritDoc}
     */
    public function processRecover(UserEntityInterface $user, RecoverEntityInterface $recover)
    {
        // Return false, iff account is not confirmed
        if ($user->getState() !== UserEntityInterface::STATE_CONFIRMED) {
            return false;
        }
        
        // Return false, iff account is recovered
        if ($recover->isRecovered() === true) {
            return false;
        }
        
        // Set recover data
        $recover
            ->setRecoveredAt(new \DateTime())
            ->setIsRecovered(true)
        ;
        
        // Get recover mapper
        $recoverMapper = $this->getRecoverMapper();
        
        // Update row
        $recoverMapper->updateRow($recover);
        
        // Get user mapper
        //$userMapper = $this->getUserMapper();
        
        // Update row
        //$userMapper->updateRow($user);
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
            // Set mailer
            $this->mailer = $this->getServiceLocator()->get('user.mailer.amazon');
        }
        
        return $this->mailer;
    }

    /**
     * {@inheritDoc}
     */
    public function getRecoverMapper()
    {
        if ($this->recoverMapper === null) {
            // Set recover mapper
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