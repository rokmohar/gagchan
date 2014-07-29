<?php

namespace User\Manager;

use User\Form\RecoverFormInterface;
use User\Mapper\RecoverMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface RecoverManagerInterface
{
    /**
     * @return \User\Form\RecoverFormInterface
     */
    public function getRecoverForm();
    
    /**
     * @param \User\Form\RecoverFormInterface $recoverForm
     */
    public function setRecoverForm(RecoverFormInterface $recoverForm);
    
    /**
     * @return \User\Mapper\RecoverMapperInterface
     */
    public function getRecoverMapper();
    
    /**
     * @param \User\Mapper\RecoverMapperInterface $recoverMapper
     */
    public function setRecoverMapper(RecoverMapperInterface $recoverMapper);
    
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