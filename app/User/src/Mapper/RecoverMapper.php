<?php

namespace User\Mapper;

use Zend\Db\ResultSet\HydratingResultSet;

use Core\Mapper\AbstractMapper;
use User\Entity\RecoverEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class RecoverMapper extends AbstractMapper implements RecoverMapperInterface
{
    /**
     * {@inheritDoc}
     */
    public function insertRow(RecoverEntityInterface $recover)
    {
        // Check if entity has pre-insert method
        if (method_exists($recover, 'preInsert')) {
            // Call a method
            call_user_func(array($recover, 'preInsert'));
        }
        
        // Extract data
        $data = $this->getHydrator()->extract($recover);
        
        // Get insert
        $insert = $this->getInsert();
        
        $insert
            ->values($data)
        ;
        
        // Prepare statement
        $statement = $this->getSql()->prepareStatementForSqlObject($insert);
        
        // Execute statement
        $result = $statement->execute();
        
        // Set identifier
        $recover->setId($result->getGeneratedValue());
        
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
        
        // Get hydrating result set
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
    public function selectRow(array $where, array $order = array())
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
     * {@inheritDoc}
     */
    public function updateRow(RecoverEntityInterface $recover)
    {
        // Check if entity has pre-update method
        if (method_exists($recover, 'preUpdate')) {
            // Call a method
            call_user_func(array($recover, 'preUpdate'));
        }
        
        // Extract data
        $data = $this->getHydrator()->extract($recover);
        
        // Get update
        $update = $this->getUpdate();
        
        $update
            ->set($data)
            ->where(array(
                'id' => $recover->getId(),
            ))
        ;
        
        // Prepare statement
        $statement = $this->getSql()->prepareStatementForSqlObject($update);
        
        // Execute statement
        return $statement->execute();
    }
}