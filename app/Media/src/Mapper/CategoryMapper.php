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
     * Select a single category.
     * 
     * @param Array $where
     * 
     * @return mixed
     */
    public function selectOne(array $where = array())
    {
        // Get select
        $select = $this->getSelect();
        
        $select
            ->where($where)
            ->order('created_at ASC')
            ->limit(1)
        ;
        
        // Get SQL
        $sql = $this->getSql();
        
        // Execute statement
        $result = $sql->prepareStatementForSqlObject($select)->execute();
        
        // Return result
        return $result->current();
    }
    
    /**
     * Select a single category by identifier.
     * 
     * @param Integer $id
     * 
     * @return mixed
     */
    public function selectOneById($id)
    {
        return $this->selectOne(array(
            'id' => $id,
        ));
    }
    
    /**
     * Select a single category by identifier.
     * 
     * @param String $slug
     * 
     * @return mixed
     */
    public function selectOneBySlug($slug)
    {
        return $this->selectOne(array(
            'slug' => $slug,
        ));
    }
    
    /**
     * Select all categories.
     * 
     * @param Array $where
     * 
     * @return mixed
     */
    public function selectAll(array $where = array())
    {
        // Get select
        $select = $this->getSelect();
        
        $select
            ->where($where)
            ->order('created_at ASC')
        ;
        
        // Get SQL
        $sql = $this->getSql();
        
        // Execute statement
        return $sql->prepareStatementForSqlObject($select)->execute();
    }
}
