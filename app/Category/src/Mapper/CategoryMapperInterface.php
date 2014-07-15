<?php

namespace Category\Mapper;

use Category\Entity\CategoryEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface CategoryMapperInterface
{
    /**
     * Insert a row.
     * 
     * @param \Category\Entity\CategoryEntityInterface $category
     */
    public function insertRow(CategoryEntityInterface $category);
    
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
     * @param \Category\Entity\CategoryEntityInterface $category
     */
    public function updateRow(CategoryEntityInterface $category);
}
