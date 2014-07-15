<?php

namespace Media\Mapper;

use Media\Entity\CommentEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface CommentMapperInterface
{
    /**
     * Insert a row.
     * 
     * @param \Media\Entity\CommentEntityInterface $comment
     */
    public function insertRow(CommentEntityInterface $comment);
    
    /**
     * Select all rows.
     * 
     * @param Array $where
     * @param Array $order
     * 
     * @return mixed
     */
    public function selectAll(array $where, array $order);
    
    /**
     * Select a row.
     * 
     * @param Array $where
     * @param Array $order
     * 
     * @return mixed
     */
    public function selectRow(array $where, array $order);
    
    /**
     * Update a row.
     * 
     * @param \Media\Entity\CommentEntityInterface $comment
     */
    public function updateRow(CommentEntityInterface $comment);
}
