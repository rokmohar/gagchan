<?php

namespace User\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

use User\Authentication\AuthenticationService;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class UserPlugin extends AbstractPlugin
{

    /**
     * @var \User\Authentication\AuthenticationService
     */
    protected $authService;
    
    /**
     * @param \User\Authentication\AuthenticationService $authService
     */
    public function __construct(AuthenticationService $authService)
    {
        $this->authService = $authService;
    }
    
    /**
     * Clear the identity.
     * 
     * @return \User\Controller\Plugin\UserPlugin
     */
    public function clearIdentity()
    {
        $this->getAuthService()->clearIdentity();
        
        return $this;
    }

    /**
     * Return true if and only if an identity is available.
     * 
     * @return bool
     */
    public function hasIdentity()
    {
        return $this->getAuthService()->hasIdentity();
    }

    /**
     * Return the authenticated identity or null if no identity is available.
     *
     * @return mixed
     */
    public function getIdentity()
    {
        return $this->getAuthService()->getIdentity();
    }

    /**
     * Return the authentication service.
     *
     * @return \User\Authentication\AuthenticationService
     */
    public function getAuthService()
    {
        return $this->authService;
    }

    /**
     * Return the authentication service.
     *
     * @param \User\Authentication\AuthenticationService $authService
     */
    public function setAuthService(AuthenticationService $authService)
    {
        $this->authService = $authService;
        
        return $this;
    }
}