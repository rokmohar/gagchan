<?php

namespace User\Manager;

use User\Entity\UserEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface UserManagerInterface
{
    /**
     * Perform authentication.
     * 
     * @param array $params
     */
    public function authenticate(array $params);
    
    
    /**
     * Authenticate through login form.
     * 
     * @return \Zend\Authentication\Result
     */
    public function login(array $data);
    
    /**
     * Perform logout.
     * 
     * @param array $params
     */
    public function logout(array $params);
    
    /**
     * Create user.
     * 
     * @param array $data
     */
    public function createUser(array $data);
    
    /**
     * Update user.
     * 
     * @param \User\Entity\UserEntityInterface $user
     * @param array                            $data
     */
    public function updateUser(UserEntityInterface $user, array $data);
    
    /**
     * Encrypt password.
     * 
     * @param string $password
     */
    public function encryptPassword($password);
    
    /**
     * Return the authentication service.
     * 
     * @return \Zend\Authentication\AuthenticationServiceInterface
     */
    public function getAuthService();
    
    /**
     * Return the user mapper.
     * 
     * @return \User\Mapper\UserMapperInterface
     */
    public function getUserMapper();
    
    /**
     * Return the user options.
     * 
     * @return \User\Options\UserOptions
     */
    public function getUserOptions();
}