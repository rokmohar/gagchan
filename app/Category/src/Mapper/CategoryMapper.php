<?php

namespace Category\Mapper;

use Zend\Db\ResultSet\HydratingResultSet;

use Core\Mapper\AbstractMapper;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class CategoryMapper extends AbstractMapper implements CategoryMapperInterface
{
    /**
     * {@inheritDoc}
     */
    public function selectAll(array $where = array())
    {
        // Get select
        $select = $this->getSelect();
        
        $select
            ->where($where)
        ;
        
        // Prepare a statement
        $stmt = $this->getSql()->prepareStatementForSqlObject($select);
        
        // Execute the statement
        $resultSet = new HydratingResultSet(
            $this->getHydrator(),
            $this->getEntityClass()
        );
        
        $resultSet->initialize($stmt->execute());
        
        // Return result
        return $resultSet;
    }
    
    /**
     * {@inheritDoc}
     */
    public function selectOne(array $where = array())
    {
        // Get select
        $select = $this->getSelect();
        
        $select
            ->where($where)
        ;
        
        // Prepare a statement
        $stmt = $this->getSql()->prepareStatementForSqlObject($select);
        
        // Execute the statement
        $resultSet = new HydratingResultSet(
            $this->getHydrator(),
            $this->getEntityClass()
        );
        
        $resultSet->initialize($stmt->execute());
        
        // Return result
        return $resultSet->current();
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
}
