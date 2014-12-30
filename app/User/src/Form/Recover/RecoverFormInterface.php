<?php

namespace User\Form\Recover;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface RecoverFormInterface
{
    /**
     * Return user identifier element.
     */
    public function addUserId();
    
    /**
     * Return email address element.
     */
    public function addEmail();
    
    /**
     * Return remote address element.
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
     * Add recovered at date and time element.
     */
    public function addRecoveredAt();
    
    /**
     * Add is recovered element.
     */
    public function addIsRecovered();
    
    /**
     * Add created at date and time element.
     */
    public function addCreatedAt();
    
    /**
     * Add updated at date and time element.
     */
    public function addUpdatedAt();
    
    /**
     * Return recover mapper.
     */
    public function getRecoverMapper();
    
    /**
     * Return user mapper.
     */
    public function getUserMapper();
}