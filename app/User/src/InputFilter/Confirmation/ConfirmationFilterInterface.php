<?php

namespace User\InputFilter\Confirmation;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface ConfirmationFilterInterface
{
    /**
     * Add user identifier filter.
     */
    public function addUserId();
    
    /**
     * Add email address filter.
     */
    public function addEmail();
    
    /**
     * Add remote address filter.
     */
    public function addRemoteAddress();
    
    /**
     * Add request at date and time filter.
     */
    public function addRequestAt();
    
    /**
     * Add request token filter.
     */
    public function addRequestToken();
    
    /**
     * Add confirmed at date and time filter.
     */
    public function addConfirmedAt();
    
    /**
     * Add is confirmed option filter.
     */
    public function addIsConfirmed();
    
    /**
     * Add created at date and time filter.
     */
    public function addCreatedAt();
    
    /**
     * Add updated at date and time filter.
     */
    public function addUpdatedAt();
    
    /**
     * Return confirmation mapper.
     */
    public function getConfirmationMapper();
    
    /**
     * Return user mapper.
     */
    public function getUserMapper();
}