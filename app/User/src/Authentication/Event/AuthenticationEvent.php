<?php

namespace User\Authentication\Event;

use Zend\EventManager\Event;
use Zend\Stdlib\RequestInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class AuthenticationEvent extends Event
{
    /**
     * Check if the authentication is satisfied.
     * 
     * @return bool
     */
    public function isSatisfied()
    {
        return $this->getParam('satisfied');
    }
    
    /**
     * Set whether the authentication is satisfied.
     * 
     * @param bool $satisfied
     */
    public function setSatisfied($satisfied)
    {
        $this->setParam('satisfied', $satisfied);
        
        return $this;
    }
    
    /**
     * Return the code.
     * 
     * @return int
     */
    public function getCode()
    {
        return $this->getParam('code');
    }
    
    /**
     * Set the code.
     * 
     * @param int $code
     */
    public function setCode($code)
    {
        $this->setParam('code', $code);
        
        return $this;
    }
    
    /**
     * Return the identity.
     * 
     * @return mixed
     */
    public function getIdentity()
    {
        return $this->getParam('identity');
    }
    
    /**
     * Set the identity.
     * 
     * @param mixed $identity
     */
    public function setIdentity($identity)
    {
        $this->setParam('identity', $identity);
        
        return $this;
    }
    
    /**
     * Return messages.
     * 
     * @return array
     */
    public function getMessages()
    {
        return $this->getParam('messages');
    }
    
    /**
     * Set messages.
     * 
     * @param array $messages
     */
    public function setMessages($messages)
    {
        $this->setParam('messages', $messages);
        
        return $this;
    }

    /**
     * Return the request.
     *
     * @return \Zend\Stdlib\RequestInterface
     */
    public function getRequest()
    {
        return $this->getParam('request');
    }

    /**
     * Set the request.
     *
     * @param \Zend\Stdlib\RequestInterface $request
     */
    public function setRequest(RequestInterface $request)
    {
        $this->setParam('request', $request);
        
        return $this;
    }
}