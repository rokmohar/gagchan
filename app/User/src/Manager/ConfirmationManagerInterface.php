<?php

namespace User\Manager;

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
     * @return \User\Mapper\ConfirmationMapperInterface
     */
    public function getConfirmationMapper();
    
    /**
     * Return the user options.
     * 
     * @return \User\Options\UserOptions
     */
    public function getUserOptions();
}