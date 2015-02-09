<?php

namespace Acl\Mapper;

use Acl\Entity\PermissionEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface PermissionMapperInterface
{
    /**
     * @param \Acl\Entity\PermissionEntityInterface $permission
     */
    public function insertRow(PermissionEntityInterface $permission);
    
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
     * @param \Acl\Entity\PermissionEntityInterface $permission
     */
    public function updateRow(PermissionEntityInterface $permission);
}
