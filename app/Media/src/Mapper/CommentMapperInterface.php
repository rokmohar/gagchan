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
     * @param \Media\Entity\CommentEntityInterface $comment
     */
    public function insertRow(CommentEntityInterface $comment);
    
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
     * @param \Media\Entity\CommentEntityInterface $comment
     */
    public function updateRow(CommentEntityInterface $comment);
}
