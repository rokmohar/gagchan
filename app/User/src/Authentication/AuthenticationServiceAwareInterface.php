<?php

namespace User\Authentication;

use Zend\Authentication\AuthenticationServiceInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface AuthenticationServiceAwareInterface
{
    /**
     * Return the authentication service.
     * 
     * @return \Zend\Authentication\AuthenticationServiceInterface
     */
    public function getAuthService();
    
    /**
     * Set the authentication service.
     * 
     * @param \Zend\Authentication\AuthenticationServiceInterface $authService
     */
    public function setAuthService(AuthenticationServiceInterface $authService);
}