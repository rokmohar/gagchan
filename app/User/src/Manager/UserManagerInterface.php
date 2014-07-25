<?php

namespace User\Manager;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface UserManagerInterface
{
    /**
     * Perform an authentication.
     * 
     * @param array $params
     * 
     * @return \Zend\Authentication\Result
     */
    public function authenticate(array $params);
    
    /**
     * Perform a logout.
     * 
     * @return \User\Manager\UserManagerInterface
     */
    public function logout(array $params);
    
    /**
     * Perform a registration.
     * 
     * @param array $data
     * 
     * @return mixed
     */
    public function register(array $data);
}