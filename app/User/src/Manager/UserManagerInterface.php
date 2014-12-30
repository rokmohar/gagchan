<?php

namespace User\Manager;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface UserManagerInterface
{
    /**
     * Return the authentication service.
     * 
     * @return \Zend\Authentication\AuthenticationServiceInterface
     */
    public function getAuthService();
    
    /**
     * Return the user form.
     * 
     * @return \User\Form\UserForm
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