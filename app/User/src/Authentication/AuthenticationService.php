<?php

namespace User\Authentication;

use Zend\Authentication\AuthenticationServiceInterface;
use Zend\Authentication\Result;
use Zend\Authentication\Storage\StorageInterface;
use Zend\Authentication\Storage\Session;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;

use User\Authentication\Event\AuthenticationEvent;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class AuthenticationService implements
    AuthenticationServiceInterface,
    EventManagerAwareInterface
{
    /**
     * @var \User\Authentication\Event\AuthenticationEvent
     */
    protected $event;
    
    /**
     * @var \Zend\EventManager\EventManagerInterface
     */
    protected $eventManager;
    
    /**
     * @array
     */
    protected $params = array();
    
    /**
     * @var \Zend\Authentication\Storage\StorageInterface
     */
    protected $storage;
    
    /**
     * @param \Zend\Authentication\Storage\StorageInterface $storage
     */
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }
    
    /**
     * {@inheritDoc}
     */
    public function authenticate()
    {
        // Get event
        $event = $this->getEvent();
        
        // Set params
        $event->setParams($this->getParams());
        
        // Trigger authenticate event
        $this->getEventManager()->trigger('authenticate', $event);
        
        // Get authentication result
        $result = new Result(
            $event->getCode(),
            $event->getIdentity(),
            $event->getMessages()
        );
        
        // Ensure storage has clean state
        $this->clearIdentity();
            
        // Check if authentication is valid
        if ($result->isValid()) {
            // Write identity to storage
            $this->getStorage()->write($result->getIdentity());
        }
        
        // Return authentication result
        return $result;
    }
    
    /**
     * Logout authenticated user.
     * 
     * @return \User\Authentication\AuthenticationService
     */
    public function logout()
    {
        // Trigger logout event
        $this->getEventManager()->trigger('logout', $this->getEvent());
        
        // Clear the identity
        $this->clearIdentity();
        
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function clearIdentity()
    {
        // Clear the storage
        $this->getStorage()->clear();
        
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getIdentity()
    {
        $storage = $this->getStorage();

        return !$storage->isEmpty() ? $storage->read() : null;
    }

    /**
     * {@inheritDoc}
     */
    public function hasIdentity()
    {
        return !$this->getStorage()->isEmpty();
    }

    /**
     * Return the event.
     * 
     * @return \User\Authentication\Event\AuthenticationEvent
     */
    public function getEvent()
    {
        if ($this->event === null) {
            // Create event
            $this->setEvent(new AuthenticationEvent());
        }
        
        return $this->event;
    }
    
    /**
     * 
     * @param \User\Authentication\Event\AuthenticationEvent $e
     */
    public function setEvent(AuthenticationEvent $e)
    {
        // Set target
        $e->setTarget($this);

        $this->event = $e;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getEventManager()
    {
        if ($this->eventManager === null) {
            $this->setEventManager(new EventManager());
        }
        
        return $this->eventManager;
    }

    /**
     * {@inheritDoc}
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $eventManager->setIdentifiers(array(
            get_class($this),
            get_called_class()
        ));
        
        $this->eventManager = $eventManager;
        
        return $this;
    }
    
    /**
     * Return params.
     * 
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }
    
    /**
     * Set params.
     * 
     * @param array $params
     */
    public function setParams(array $params)
    {
        $this->params = $params;
        
        return $this;
    }
    
    /**
     * Check if param exists.
     * 
     * @param string $name
     */
    public function hasParam($name)
    {
        return isset($this->params[$name]);
    }
    
    /**
     * Add a param.
     * 
     * @param string $name
     * @param mixed  $value
     */
    public function addParam($name, $value)
    {
        // Check if param exists
        if ($this->hasParam($name)) {
            // Throw an exception
            throw new \Exception(
                sprintf("Param with name \"%s\" already exists.", $name)
            );
        }
        
        // Set param
        $this->params[$name] = $value;
        
        return $this;
    }
    
    /**
     * Remove a param.
     * 
     * @param string $name
     */
    public function removeParam($name)
    {
        // Check if param does not exists
        if (!$this->hasParam($name)) {
            // Throw an exception
            throw new \Exception(
                sprintf("Param with name \"%s\" does not exists.", $name)
            );
        }
        
        // Remove param
        unset($this->params[$name]);
        
        return $this;
    }
    
    /**
     * Return the storage.
     * 
     * @return \Zend\Authentication\Storage\StorageInterface
     */
    public function getStorage()
    {
        if ($this->storage === null) {
            // Create storage
            $this->storage = new Session(get_class($this));
        }
        
        return $this->storage;
    }
}