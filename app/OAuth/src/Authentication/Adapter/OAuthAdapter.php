<?php

namespace OAuth\Authentication\Adapter;

use Zend\Authentication\Result;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\Session\Container;

use Core\Utils\Transliterator;
use User\Authentication\Adapter\AdapterInterface;
use User\Authentication\Event\AuthenticationEvent;
use User\Entity\UserEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class OAuthAdapter implements AdapterInterface, ServiceManagerAwareInterface
{
    /**
     * @var \Hybrid_Auth
     */
    protected $hybridAuth;
    
    /**
     * @var \OAuth\Mapper\OAuthMapperInterface
     */
    protected $oauthMapper;
    
    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $serviceManager;
    
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
        
        // Get param
        $provider = $event->getParam('provider');
        
        // Check if provider is given
        if (empty($provider)) {
            // Set event parameters
            $event
                ->setSatisfied(false)
                ->setCode(Result::FAILURE_UNCATEGORIZED)
                ->setMessages(array(
                    "Provider \"%s\" is not given.",
                ))
            ;
            
            // Authentication failed
            return false;
        }
        
        // Get hybrid auth
        $hybridAuth = $this->getHybridAuth();
        
        // Check if provider is enabled
        if (!array_key_exists($provider, $hybridAuth->getProviders())) {
            // Set event parameters
            $event
                ->setSatisfied(false)
                ->setCode(Result::FAILURE_UNCATEGORIZED)
                ->setMessages(array(
                    printf("Provider \"%s\" is not enabled.", $provider),
                ))
            ;
            
            // Authentication failed
            return false;
        }
        
        // Get adapter
        $adapter = $hybridAuth->authenticate($provider);
        
        // Get profile
        $profile = $adapter->getUserProfile();
        
        // Get oauth mapper
        $oauthMapper = $this->getOAuthMapper();
        
        // Select row
        $row = $oauthMapper->selectRowByProviderId(
            $provider,
            $profile->identifier
        );
        
        // Get user mapper
        $userMapper = $this->getUserMapper();
        
        // Check if row is not empty
        if (!empty($row)) {
            // Get user
            $user = $userMapper->selectRowById($row->getUserId());
        }
        else if(!empty($profile->email)) {
            // Get user
            $user = $userMapper->selectRowByEmail($profile->email);
            
            // Check if user is empty
            if (empty($user)) {
                // Create user
                $user = new \User\Entity\UserEntity();
                
                // Set username
                $user->setUsername($this->generateUsername($profile));
                
                // Set email address
                $user->setEmail($profile->email);
                
                // Set state
                $user->setState(UserEntityInterface::STATE_CONFIRMED);
                
                // Insert user
                $this->getUserMapper()->insertRow($user);
            }
            
            // Create OAuth entity
            $oauth = new \OAuth\Entity\OAuthEntity();
            
            // Set user identifier
            $oauth->setUserId($user->getId());
            
            // Set provider
            $oauth->setProvider($provider);
            
            // Set provider identifier
            $oauth->setProviderId($profile->identifier);
            
            // Insert oauth
            $this->getOAuthMapper()->insertRow($oauth);
        }
        else {
            // Set event parameters
            $event
                ->setSatisfied(false)
                ->setCode(Result::FAILURE_IDENTITY_NOT_FOUND)
                ->setMessages(array(
                    'You can not log in. Please use any alternative.',
                ))
            ;
            
            // Stop propagation
            $event->stopPropagation();
            
            // Authentication failed
            return false;
        }
        
        // Check if state is correct
        if ($user->getState() == UserEntityInterface::STATE_DISABLED) {
            // Set event parameters
            $event
                ->setSatisfied(false)
                ->setCode(Result::FAILURE_UNCATEGORIZED)
                ->setMessages(array(
                    'Your account has been disabled.',
                ))
            ;
            
            // Stop propagation
            $event->stopPropagation();
            
            // Authentication failed
            return false;
        }
        else if (
            $user->getState() == UserEntityInterface::STATE_UNCONFIRMED &&
            $user->getEmail() == $profile->email
        ) {
            // Confirm account
            $user->setState(UserEntityInterface::STATE_CONFIRMED);
            
            // Update user
            $userMapper->updateRow($user);
        }
        
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
     * Logout user.
     * 
     * @return \OAuth\Authentication\Adapter\OAuthAdapter
     */
    public function logout()
    {
        // Get hybrid auth
        $hybridAuth = $this->getHybridAuth();
        
        // Logout adapters
        $hybridAuth->logoutAllProviders();
        
        return $this;
    }
    
    /**
     * Get username from hybrid auth profile.
     * 
     * @param \Hybrid_User_Profile $profile
     * 
     * @return string
     */
    protected function generateUsername(\Hybrid_User_Profile $profile)
    {
        // Explode email
        $email = explode('@', $profile->email);
        
        // Check if email has contents
        if (0 < count($email)) {
            // Set first part of email
            $username = $email[0];
        }
        else {

            // Display name
            $displayName = $profile->displayName;

            // Check if display name is empty
            if (empty($displayName)) {
                // Get display name from name
                $displayName = $profile->firstName . " " . $profile->lastName;
            }

            // Transliterate string
            $username = Transliterator::transliterate($displayName);

            // Replace non-alphanum characters
            $username = preg_replace('/[^a-zA-Z\d\s]/', '', strtolower($username));

            // Replace whitespaces
            $username = preg_replace('/[\s]+/', '.', trim($username));
        }
        
        // Get row
        $row = $this->getUserMapper()->selectRowByUsername($username);
        
        // Check if row is empty
        if (empty($row)) {
            // Return username
            return $username;
        }

        // Generate username
        return $this->prependUsername($username);
    }
    
    /**
     * Append random number to username.
     * 
     * @param string $username
     * 
     * @return string
     */
    protected function prependUsername($username)
    {
        // Generate random number
        $newUsername = $username . rand(1, 9999);
        
        // Get row
        $row = $this->getUserMapper()->selectRowByUsername($newUsername);
        
        // Check if row is empty
        if (empty($row)) {
            // Return username
            return $newUsername;
        }
        
        // Generate username
        return $this->prependUsername($username);
    }
    
    /**
     * Get the hybrid auth adapter.
     * 
     * @return \Hybrid_Auth
     */
    public function getHybridAuth()
    {
        if ($this->hybridAuth === null) {
            return $this->hybridAuth = $this->getServiceManager()->get(
                'oauth.hybridauth'
            );
        }
        
        return $this->hybridAuth;
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
     * @return \OAuth\Mapper\OAuthMapperInterface
     */
    public function getOAuthMapper()
    {
        if ($this->oauthMapper === null) {
            return $this->oauthMapper = $this->getServiceManager()->get(
                'oauth.mapper.oauth'
            );
        }
        
        return $this->oauthMapper;
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