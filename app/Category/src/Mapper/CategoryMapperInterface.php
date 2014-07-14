<?php

namespace Category\Mapper;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface CategoryMapperInterface
{
    /**
     * Select and return all rows.
     * 
     * @return mixed
     */
    public function selectAll(array $where);
    
    /**
     * Select and return one row.
     * 
     * @return mixed
     */
    public function selectRow(array $where);
}
