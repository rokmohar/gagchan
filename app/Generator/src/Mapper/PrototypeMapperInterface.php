<?php

namespace Generator\Mapper;

use Generator\Entity\PrototypeEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface PrototypeMapperInterface
{
    /**
     * Insert a row.
     * 
     * @param \Generator\Entity\PrototypeEntityInterface $prototype
     */
    public function insertRow(PrototypeEntityInterface $prototype);
    
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
     * @param \Generator\Entity\PrototypeEntityInterface $prototype
     */
    public function updateRow(PrototypeEntityInterface $prototype);
}
