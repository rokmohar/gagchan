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
     * @param \Media\Entity\VoteEntityInterface $vote
     */
    public function insertRow(VoteEntityInterface $vote);
    
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
     * @param \Media\Entity\VoteEntityInterface $vote
     */
    public function updateRow(VoteEntityInterface $vote);
        
}
