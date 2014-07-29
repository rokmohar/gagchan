<?php

namespace User\InputFilter;

use User\Mapper\RecoverMapperInterface;
use User\Mapper\UserMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface RecoverFilterInterface
{
    /**
     * {@inheritDoc}
     */
    public function addId();
    
    /**
     * {@inheritDoc}
     */
    public function addUserId();
    
    /**
     * {@inheritDoc}
     */
    public function addEmail();
    
    /**
     * {@inheritDoc}
     */
    public function addRemoteAddress();
    
    /**
     * {@inheritDoc}
     */
    public function addRequestAt();
    
    /**
     * {@inheritDoc}
     */
    public function addRequestToken();
    
    /**
     * {@inheritDoc}
     */
    public function addConfirmedAt();
    
    /**
     * {@inheritDoc}
     */
    public function addIsConfirmed();
    
    /**
     * {@inheritDoc}
     */
    public function getRecoverMapper();
    
    /**
     * {@inheritDoc}
     */
    public function setRecoverMapper(RecoverMapperInterface $recoverMapper);
    
    /**
     * {@inheritDoc}
     */
    public function getUserMapper();
    
    /**
     * {@inheritDoc}
     */
    public function setUserMapper(UserMapperInterface $userMapper);
}