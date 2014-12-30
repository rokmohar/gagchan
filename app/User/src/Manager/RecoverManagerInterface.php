<?php

namespace User\Manager;

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
     * @return \User\Mapper\RecoverMapperInterface
     */
    public function getRecoverMapper();
    
    /**
     * Return the user options.
     * 
     * @return \User\Options\UserOptions
     */
    public function getUserOptions();
}