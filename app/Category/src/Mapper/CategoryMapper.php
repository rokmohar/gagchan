<?php

namespace Category\Mapper;

use Zend\Db\ResultSet\HydratingResultSet;

use Core\Mapper\AbstractMapper;
use Category\Entity\CategoryEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class CategoryMapper extends AbstractMapper implements CategoryMapperInterface
{
    /**
     * {@inheritDoc}
     */
    public function insertRow(CategoryEntityInterface $category)
    {
        // Check if entity has pre-insert method
        if (method_exists($category, 'preInsert')) {
            // Call a method
            call_user_func(array($category, 'preInsert'));
        }
        
        // Get SQL insert
        $insert = $this->getInsert();
        
        $insert
            ->values(array(
                'slug'       => $category->getSlug(),               
                'name'       => $category->getName(),
                'created_at' => $category->getCreatedAt()->format('Y-m-d H:i:s'),
                'updated_at' => $category->getUpdatedAt()->format('Y-m-d H:i:s'),
            ))
        ;
        
        // Get SQL
        $sql = $this->getSql();
        
        // Prepare and execute statement
        $result = $sql->prepareStatementForSqlObject($insert)->execute();
        
        // Return result
        return $result;
    }
    
    /**
     * {@inheritDoc}
     */
    public function selectAll(array $where = array(), array $order = array())
    {
        // Get select
        $select = $this->getSelect();
        
        $select
            ->where($where)
            ->order($order)
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
    public function selectRow(array $where = array(), array $order = array())
    {
        // Get select
        $select = $this->getSelect();
        
        $select
            ->where($where)
            ->order($order)
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
     * Select a row by identifier.
     * 
     * @param Integer $id
     * 
     * @return mixed
     */
    public function selectRowById($id)
    {
        return $this->selectRow(array(
            'id' => $id,
        ));
    }
    
    /**
     * Select a row category by slug.
     * 
     * @param String $slug
     * 
     * @return mixed
     */
    public function selectRowBySlug($slug)
    {
        return $this->selectRow(array(
            'slug' => $slug,
        ));
    }
    
    /**
     * {@inheritDoc}
     */
    public function updateRow(CategoryEntityInterface $category)
    {
        // Check if entity has pre-update method
        if (method_exists($category, 'preUpdate')) {
            // Call a method
            call_user_func(array($category, 'preUpdate'));
        }
        
        // Get update
        $update = $this->getUpdate();
        
        $update
            ->values(array(
                'slug'       => $category->getSlug(),               
                'name'       => $category->getName(),
                'created_at' => $category->getCreatedAt()->format('Y-m-d H:i:s'),
                'updated_at' => $category->getUpdatedAt()->format('Y-m-d H:i:s'),
            ))
            ->where(array(
                'id' => $category->getId(),
            ))
        ;
        
        // Get SQL
        $sql = $this->getSql();
        
        // Prepare and execute statement
        $result = $sql->prepareStatementForSqlObject($update)->execute();
        
        // Return result
        return $result;
    }
}
