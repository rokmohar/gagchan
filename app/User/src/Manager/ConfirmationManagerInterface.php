<?php

namespace User\Manager;

use User\Form\ConfirmationFormInterface;
use User\Mapper\ConfirmationMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface ConfirmationManagerInterface
{
    /**
     * @return \User\Form\ConfirmationFormInterface
     */
    public function getConfirmationForm();
    
    /**
     * @param \User\Form\ConfirmationFormInterface $confirmationForm
     */
    public function setConfirmationForm(ConfirmationFormInterface $confirmationForm);
    
    /**
     * @return \User\Mapper\ConfirmationMapperInterface
     */
    public function getConfirmationMapper();
    
    /**
     * @param \User\Mapper\ConfirmationMapperInterface $confirmationMapper
     */
    public function setConfirmationMapper(ConfirmationMapperInterface $confirmationMapper);
    
    /**
     * Return the user options.
     * 
     * @return \User\Options\UserOptionsInterface
     */
    public function getUserOptions();
    
    /**
     * Set the user options.
     * 
     * @param \User\Options\UserOptionsInterface $userOptions
     */
    public function setUserOptions(UserOptionsInterface $userOptions);
}