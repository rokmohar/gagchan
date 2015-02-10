<?php

namespace Security\Mapper;

use Security\Entity\RoleEntityInterface;
use User\Entity\UserEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface RoleMapperInterface
{
    /**
     * @param \Security\Entity\RoleEntityInterface $role
     */
    public function insertRow(RoleEntityInterface $role);
    
    /**
     * @param array $where
     * @param array $order
     * 
     * @return mixed
     */
    public function selectAll(array $where, array $order);
    
    /**
     * @param array $where
     * @param array $order
     * 
     * @return mixed
     */
    public function selectRow(array $where, array $order);
    
    /**
     * @param \Security\Entity\RoleEntityInterface $role
     */
    public function updateRow(RoleEntityInterface $role);
    
    /**
     * @param \User\Entity\UserEntityInterface $user
     * @param \Security\Entity\RoleEntityInterface  $role
     */
    public function insertRole(UserEntityInterface $user, RoleEntityInterface $role);
    
    /**
     * @param \User\Entity\UserEntityInterface $user
     * @param \Security\Entity\RoleEntityInterface  $role
     */
    public function deleteRole(UserEntityInterface $user, RoleEntityInterface $role);
    
    /**
     * @param \User\Entity\UserEntityInterface $user
     */
    public function selectByUser(UserEntityInterface $user);
}
