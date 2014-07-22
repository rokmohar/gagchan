<?php

namespace User\Mapper;

use User\Entity\ConfirmationEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface ConfirmationMapperInterface
{
    /**
     * Insert a row.
     * 
     * @param \User\Entity\ConfirmationEntityInterface $confirmation
     */
    public function insertRow(ConfirmationEntityInterface $confirmation);
    
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
     * @param \User\Entity\ConfirmationEntityInterface $confirmation
     */
    public function updateRow(ConfirmationEntityInterface $confirmation);
}