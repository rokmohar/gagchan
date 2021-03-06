<?php

namespace User\Mapper;

use User\Entity\UserEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface UserMapperInterface
{
    /**
     * Insert a row.
     * 
     * @param \User\Entity\UserEntityInterface $user
     */
    public function insertRow(UserEntityInterface $user);
    
    /**
     * Select all rows.
     * 
     * @param array $where
     * @param array $order
     * 
     * @return mixed
     */
    public function selectAll(array $where, array $order);
    
    /**
     * Select a row.
     * 
     * @param array $where
     * @param array $order
     * 
     * @return mixed
     */
    public function selectRow(array $where, array $order);
    
    /**
     * Update a row.
     * 
     * @param \User\Entity\UserEntityInterface $user
     */
    public function updateRow(UserEntityInterface $user);
}