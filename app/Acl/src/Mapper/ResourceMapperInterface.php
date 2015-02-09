<?php

namespace Acl\Mapper;

use Acl\Entity\ResourceEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface ResourceMapperInterface
{
    /**
     * @param \Acl\Entity\ResourceEntityInterface $resource
     */
    public function insertRow(ResourceEntityInterface $resource);
    
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
     * @param \Acl\Entity\ResourceEntityInterface $resource
     */
    public function updateRow(ResourceEntityInterface $resource);
}
