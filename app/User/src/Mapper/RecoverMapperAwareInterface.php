<?php

namespace User\Mapper;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface RecoverMapperAwareInterface
{
    /**
     * Return the recover mapper.
     * 
     * @return \User\Mapper\RecoverMapperInterface
     */
    public function getRecoverMapper();
    
    /**
     * Set the recover mapper.
     * 
     * @param \User\Mapper\RecoverMapperInterface $recoverMapper
     */
    public function setRecoverMapper(RecoverMapperInterface $recoverMapper);
}