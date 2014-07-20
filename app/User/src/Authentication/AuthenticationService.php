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
    
    protected $request;
    
    public function setRequest(\Zend\Http\Request $request)
    {
        $this->request = $request;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function authenticate()
    {
        // Get event
        $event = $this->getEvent();
        
        // Set request
        $event->setRequest($this->request);
        
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

        return ($storage->isEmpty() === false) ? $storage->read() : null;
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
     * Return the storage.
     * 
     * @return \Zend\Authentication\Storage\StorageInterface
     */
    public function getStorage()
    {
        if ($this->storage === null) {
            $this->setStorage(new Session(get_class($this)));
        }
        
        return $this->storage;
    }
    
    /**
     * Set the storage.
     * 
     * @param \Zend\Authentication\Storage\StorageInterface $storage
     */
    public function setStorage(StorageInterface $storage)
    {
        $this->storage = $storage;
        
        return $this;
    }
}