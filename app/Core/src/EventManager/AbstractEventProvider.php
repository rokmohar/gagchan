<?php

namespace Core\EventManager;

use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
abstract class AbstractEventProvider implements EventManagerAwareInterface
{
    /**
     * @var \Zend\EventManager\EventManagerInterface
     */
    protected $eventManager;
    
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
}