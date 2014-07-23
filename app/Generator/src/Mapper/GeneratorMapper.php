<?php

namespace Generator\Mapper;

use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;

use Core\Mapper\AbstractMapper;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class GeneratorMapper extends AbstractMapper
{
    /**
     * {@inheritDoc}
     */
    public function insertRow(GeneratorEntityInterface $generator)
    {
        // Check if entity has pre-insert method
        if (method_exists($generator, 'preInsert')) {
            // Call a method
            call_user_func(array($generator, 'preInsert'));
        }
        
        // Extract data
        $data = $this->getHydrator()->extract($generator);
        
        // Get SQL insert
        $insert = $this->getInsert();
        
        $insert
            ->values($data)
        ;
        
        // Prepare statement
        $statement = $this->getSql()->prepareStatementForSqlObject($insert);
        
        // Execute statement
        $result = $statement->execute();
        
        // Set identifier
        $generator->setId($result->getGeneratedValue());
        
        // Return result
        return $result;
    }
    
    /**
     * {@inheritDoc}
     */
    public function selectAll(array $where = array(), array $order = array(), $limit = null)
    {
        // Get select
        $select = $this->getSelect();
        
        $select
            ->where($where)
            ->order($order)
        ;
        
        // Check if limit given
        if (is_numeric($limit) === true) {
            // Add limit
            $select->limit($limit);
        }
        
        // Get result set
        $resultSet = new HydratingResultSet(
            $this->getHydrator(),
            $this->getEntityClass()
        );
        
        // Get select for paginator
        $adapter = new DbSelect($select, $this->getDbAdapter(), $resultSet);
        
        // Return paginator
        return new Paginator($adapter); 
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
            ->limit(1)
        ;
        
        // Prepare a statement
        $stmt = $this->getSql()->prepareStatementForSqlObject($select);
        
        // Get hydrating result set
        $resultSet = new HydratingResultSet(
            $this->getHydrator(),
            $this->getEntityClass()
        );
        
        $resultSet->initialize($stmt->execute());
        
        // Return result
        return $resultSet->current();
    }
    
    /**
     * Select row by media_prototype.
     * 
     * @param int $id
     * 
     * @return mixed
     */
    public function selectRowById($id)
    {
        return $this->selectRow(array(
            'id' => $id,
        ));
    }

}