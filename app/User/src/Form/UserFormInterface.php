<?php

namespace User\Form;

use User\Mapper\UserMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface UserFormInterface
{
    /**
     * Add the captcha element.
     * 
     * @return \User\Form\UserFormInterface
     */
    public function addCaptcha();
    
    /**
     * Add the CSRF element.
     * 
     * @return \User\Form\UserFormInterface
     */
    public function addCsrf();
    
    /**
     * Add the email address element.
     * 
     * @return \User\Form\UserFormInterface
     */
    public function addEmail();
    
    /**
     * Add the identifier element.
     * 
     * @return \User\Form\UserFormInterface
     */
    public function addId();
    
    /**
     * Add the password element.
     * 
     * @return \User\Form\UserFormInterface
     */
    public function addPassword();
    
    /**
     * Add the password verify element.
     * 
     * @return \User\Form\UserFormInterface
     */
    public function addPasswordVerify();
    
    /**
     * Add the state element.
     * 
     * @return \User\Form\UserFormInterface
     */
    public function addState();
    
    /**
     * Add the submit element.
     * 
     * @return \User\Form\UserFormInterface
     */
    public function addSubmit();
    
    /**
     * Add the username element.
     * 
     * @return \User\Form\UserFormInterface
     */
    public function addUsername();
    
    /**
     * Return the user mapper.
     * 
     * @return \User\Mapper\UserMapperInterface
     */
    public function getUserMapper();
    
    /**
     * Set the user mapper.
     * 
     * @param \User\Mapper\UserMapperInterface $userMapper
     */
    public function setUserMapper(UserMapperInterface $userMapper);
}