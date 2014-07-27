<?php

namespace User\Mapper;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface ConfirmationMapperAwareInterface
{
    /**
     * Return the confirmation mapper.
     * 
     * @return \User\Mapper\ConfirmationMapperInterface
     */
    public function getConfirmationMapper();
    
    /**
     * Set the confirmation mapper.
     * 
     * @param \User\Mapper\ConfirmationMapperInterface $confirmationMapper
     */
    public function setConfirmationMapper(ConfirmationMapperInterface $confirmationMapper);
}