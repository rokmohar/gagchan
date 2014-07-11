<?php

namespace Media\Mapper;

use Core\Mapper\AbstractMapper;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class CategoryMapper extends AbstractMapper implements CategoryMapperInterface
{
    /**
     * @return mixed
     */
    public function getCategories()
    {
        // Get select
        $select = $this->getSelect();
        
        $select
            ->order('created_at ASC')
        ;
        
        // Get SQL
        $sql = $this->getSql();
        
        // Execute statement
        return $sql->prepareStatementForSqlObject($select)->execute();
    }
}
