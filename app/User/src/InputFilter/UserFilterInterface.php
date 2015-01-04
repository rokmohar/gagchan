<?php

namespace User\InputFilter;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface UserFilterInterface
{
    /**
     * Add identifier.
     */
    public function addId();
    
    /**
     * Add username filter.
     */
    public function addUsername();
    
    /**
     * Add email address filter.
     */
    public function addEmail();
    
    /**
     * Add password filter.
     */
    public function addPassword();
    
    /**
     * Add password verify filter.
     */
    public function addPasswordVerify();
    
    /**
     * Add state filter.
     */
    public function addState();
    
    /**
     * Add created at date and time filter.
     */
    public function addCreatedAt();
    
    /**
     * Add updated at date and time filter.
     */
    public function addUpdatedAt();
    
    /**
     * Return the user mapper.
     * 
     * @return \User\Mapper\UserMapperInterface
     */
    public function getUserMapper();
}