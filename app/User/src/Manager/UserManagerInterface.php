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
     * Perform login through form.
     * 
     * @param array $data
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
     * Return user account form.
     * 
     * @return \User\Form\User\UserFormInterface
     */
    public function getAccountForm();
    
    /**
     * Return the authentication service.
     * 
     * @return \Zend\Authentication\AuthenticationServiceInterface
     */
    public function getAuthService();
    
    /**
     * Return user login form.
     * 
     * @return \User\Form\User\UserFormInterface
     */
    public function getLoginForm();
    
    /**
     * Return user password form.
     * 
     * @return \User\Form\User\UserFormInterface
     */
    public function getPasswordForm();
    
    /**
     * Return user signup form.
     * 
     * @return \User\Form\User\UserFormInterface
     */
    public function getSignupForm();
    
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