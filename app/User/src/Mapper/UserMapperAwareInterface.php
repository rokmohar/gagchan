<?php

namespace User\Mapper;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface UserMapperAwareInterface
{
    /**
     * Return the user mapper.
     * 
     * @return \User\Mapper\UserMapperInterface
     */
    public function getUserMapper();
    
    /**
     * Set the user mapper.
     * 
     * @param \User\Mapper\UserMapperInterface $userMapper
     */
    public function setUserMapper(UserMapperInterface $userMapper);
}