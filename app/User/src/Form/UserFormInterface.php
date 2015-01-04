<?php

namespace User\Form;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface UserFormInterface
{
    /**
     * Add identifier element.
     */
    public function addId();
    
    /**
     * Add username element.
     */
    public function addUsername();
    
    /**
     * Add email address element.
     */
    public function addEmail();
    
    /**
     * Add password element.
     */
    public function addPassword();
    
    /**
     * Add password verify element.
     */
    public function addPasswordVerify();
    
    /**
     * Add state element.
     */
    public function addState();
    
    /**
     * Add created at date and time element.
     */
    public function addCreatedAt();
    
    /**
     * Add updated at date and time element.
     */
    public function addUpdatedAt();
    
    /**
     * Return the user mapper.
     * 
     * @return \User\Mapper\UserMapperInterface
     */
    public function getUserMapper();
}