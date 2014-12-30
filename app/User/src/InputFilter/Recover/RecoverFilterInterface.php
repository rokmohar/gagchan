<?php

namespace User\InputFilter\Recover;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface RecoverFilterInterface
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
     * Add recovered at date and time filter.
     */
    public function addRecoveredAt();
    
    /**
     * Add is recovered filter.
     */
    public function addIsRecovered();
    
    /**
     * Return recover mapper.
     */
    public function getRecoverMapper();
    
    /**
     * Return user mapper.
     */
    public function getUserMapper();
}