<?php

namespace User\Form\Confirmation;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface ConfirmationFormInterface
{
    /**
     * Add user identifier element.
     */
    public function addUserId();
    
    /**
     * Add email address element.
     */
    public function addEmail();
    
    /**
     * Add remote address element.
     */
    public function addRemoteAddress();
    
    /**
     * Add request at date and time element.
     */
    public function addRequestAt();
    
    /**
     * Add request token element.
     */
    public function addRequestToken();
    
    /**
     * Add confirmed at date and time element.
     */
    public function addConfirmedAt();
    
    /**
     * Add is confirmed element.
     */
    public function addIsConfirmed();
    
    /**
     * Add created at date and time element.
     */
    public function addCreatedAt();
    
    /**
     * Add updated at date and time element.
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