<?php

namespace User\Form;

use User\Mapper\ConfirmationMapperInterface;
use User\Mapper\UserMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface ConfirmationFormInterface
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
    public function getConfirmationMapper();
    
    /**
     * {@inheritDoc}
     */
    public function setConfirmationMapper(ConfirmationMapperInterface $confirmationMapper);
    
    /**
     * {@inheritDoc}
     */
    public function getUserMapper();
    
    /**
     * {@inheritDoc}
     */
    public function setUserMapper(UserMapperInterface $userMapper);
}