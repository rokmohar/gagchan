<?php

namespace Core\EventManager;

use Traversable;

use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
abstract class EventProvider implements EventManagerAwareInterface
{
    /**
     * @var \Zend\EventManager\EventManagerInterface
     */
    protected $events;

    /**
     * Return the event manager.
     *
     * Lazy-loads an EventManager instance if none registered.
     *
     * @return \Zend\EventManager\EventManagerInterface
     */
    public function getEventManager()
    {
        if (null === $this->events) {
            $this->events = new EventManager();
        }
        
        return $this->events;
    }

    /**
     * Set the event manager instance used by this context.
     *
     * @param \Zend\EventManager\EventManagerInterface $events
     * 
     * @return mixed
     */
    public function setEventManager(EventManagerInterface $events)
    {
        $identifiers = array(__CLASS__, get_called_class());
        
        if (isset($this->eventIdentifier)) {
            if (
                is_string($this->eventIdentifier) ||
                is_array($this->eventIdentifier) ||
                $this->eventIdentifier instanceof Traversable
            ) {
                $identifiers = array_unique(array_merge($identifiers, (array) $this->eventIdentifier));
            }
            elseif (is_object($this->eventIdentifier)) {
                $identifiers[] = $this->eventIdentifier;
            }
            
            // Silently ignore invalid event types
        }
        
        $events->setIdentifiers($identifiers);
        $this->events = $events;
        
        return $this;
    }
}