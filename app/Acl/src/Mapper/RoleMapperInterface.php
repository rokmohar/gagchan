<?php

namespace Acl\Mapper;

use Acl\Entity\RoleEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface RoleMapperInterface
{
    /**
     * @param \Acl\Entity\RoleEntityInterface $role
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
     * @param \Acl\Entity\RoleEntityInterface $role
     */
    public function updateRow(RoleEntityInterface $role);
}
