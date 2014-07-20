<?php

namespace Media\Mapper;

use Media\Entity\VoteEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface VoteMapperInterface
{
    /**
     * Insert a row.
     * 
     * @param \Media\Entity\VoteEntityInterface $vote
     */
    public function insertRow(VoteEntityInterface $vote);
    
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
     * @param \Media\Entity\VoteEntityInterface $vote
     */
    public function updateRow(VoteEntityInterface $vote);
        
}
