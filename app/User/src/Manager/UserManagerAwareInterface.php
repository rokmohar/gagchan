<?php

namespace User\Mapper;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface UserManagerAwareInterface
{
    /**
     * Return the user manager.
     * 
     * @return \User\Manager\UserManagerInterface
     */
    public function getUserManager();
    
    /**
     * Set the user manager.
     * 
     * @param \User\Manager\UserManagerInterface $userMapanger
     */
    public function setUserManager(UserManagerInterface $userMapanger);
}