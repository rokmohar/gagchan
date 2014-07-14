<?php

namespace Media\Mapper;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface MediaMapperInterface
{
    /**
     * Select and return all rows.
     * 
     * @param Array   $where
     * @param Array   $order
     * @param Integer $limit
     * 
     * @return mixed
     */
    public function selectAll(array $where, array $order, $limit);
    
    /**
     * Select and return one row.
     * 
     * @param Array $where
     * @param Array $order
     * 
     * @return mixed
     */
    public function selectRow(array $where, array $order);
}
