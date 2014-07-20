<?php

namespace User\Authentication\Adapter;

use Zend\Authentication\Result;
use Zend\Crypt\Password\Bcrypt;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\Session\Container;

use User\Authentication\Event\AuthenticationEvent;
use User\Entity\UserEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class DbAdapter implements AdapterInterface, ServiceManagerAwareInterface
{
    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $serviceManager;
    
    /**
     * @var \User\Hydrator\UserHydrator
     */
    protected $userHydrator;
    
    /**
     * @var \User\Mapper\UserMapperInterface
     */
    protected $userMapper;
    
    /**
     * {@inheritDoc}
     */
    public function authenticate(AuthenticationEvent $event)
    {
        // Check if adapter is satisfied
        if ($event->isSatisfied() === true) {
            // Authentication successful
            return true;
        }
        
        // Get request
        $request = $event->getRequest();
        
        // Check if request is empty
        if (empty($request) === true) {
            // Throw an exception
            throw new \RuntimeException('Request was not provided.');
        }
        
        // Get posted data
        $email    = $request->getPost()->get('email');
        $password = $request->getPost()->get('password');
        
        // Get user
        $user = $this->getUserMapper()->selectRowByEmail($email);
        
        // Check if user is empty
        if (empty($user) === true) {
            // Set event parameters
            $event
                ->setSatisfied(false)
                ->setCode(Result::FAILURE_IDENTITY_NOT_FOUND)
                ->setMessages(array(
                    'A record with the supplied identity could not be found.',
                ))
            ;
            
            // Authentication not successful
            return false;
        }
        
        // Encryption service
        $crypt = new Bcrypt(array(
            'cost' => 14,
        ));
        
        // Verify if a password is correct
        if ($crypt->verify($password, $user->getPassword()) === false) {
            // Set event parameters
            $event
                ->setSatisfied(false)
                ->setCode(Result::FAILURE_CREDENTIAL_INVALID)
                ->setMessages(array(
                    'A record with the supplied identity could not be found.',
                ))
            ;
            
            // Authentication not successful
            return false;
        }
        
        // Update password hash if the cost has changed
        $this->updatePasswordHash($user, $password, $crypt);
        
        // Regenerate the ID
        Container::getDefaultManager()->regenerateId();
        
        // Set event parameters
        $event
            ->setSatisfied(true)
            ->setCode(Result::SUCCESS)
            ->setIdentity($user->getId())
            ->setMessages(array('Authentication successful.'))
        ;
        
        // Authentication successful
        return true;
    }
    
    /**
     * Update password hash if the cost has changed
     * 
     * @param \User\Entity\UserEntityInterface $user
     * @param string                           $password
     * @param \Zend\Crypt\Password\Bcrypt      $bcrypt
     */
    protected function updatePasswordHash(UserEntityInterface $user, $password, Bcrypt $bcrypt)
    {
        // Get hash
        $hash = explode('$', $user->getPassword());
        
        // Check if hash has changed
        if ($hash[2] !== $bcrypt->getCost()) {
            // Hydrate user password
            $user = $this->getHydrator()->hydrate(compact('password'), $user);
            
            // Update user
            $this->getMapper()->update($user);
        }
        
        return $this;
    }
    
    /**
     * Return the service manager.
     * 
     * @return \Zend\ServiceManager\ServiceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }
    
    /**
     * {@inheritDoc}
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        
        return $this;
    }
    
    /**
     * Get the user hydrator.
     *
     * @return \User\Hydrator\UserHydrator
     */
    public function getUserHydrator()
    {
        if ($this->userHydrator === null) {
            return $this->userHydrator = $this->serviceManager->get(
                'user.hydrator.user'
            );
        }
        return $this->userHydrator;
    }
    
    /**
     * @return \User\Mapper\UserMapperInterface
     */
    public function getUserMapper()
    {
        if ($this->userMapper === null) {
            return $this->userMapper = $this->getServiceManager()->get(
                'user.mapper.user'
            );
        }
        
        return $this->userMapper;
    }
}