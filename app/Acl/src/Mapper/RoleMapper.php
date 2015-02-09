<?php

namespace Acl\Mapper;

use Zend\Db\ResultSet\HydratingResultSet;

use Core\Mapper\AbstractMapper;
use Acl\Entity\RoleEntityInterface;
//use User\Entity\UserEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class RoleMapper extends AbstractMapper implements RoleMapperInterface
{
    /**
     * {@inheritDoc}
     */
    public function insertRow(RoleEntityInterface $role)
    {
        // Check if entity has pre-insert method
        if (method_exists($role, 'preInsert')) {
            // Call a method
            call_user_func(array($role, 'preInsert'));
        }
        
        // Extract data
        $data = $this->getHydrator()->extract($role);
        
        // Get insert
        $insert = $this->getInsert();
        $insert->values($data);
        
        // Prepare statement
        $statement = $this->getSql()->prepareStatementForSqlObject($insert);
        
        // Execute statement
        $result = $statement->execute();
        
        // Set identifier
        $role->setId($result->getGeneratedValue());
        
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
            ->limit(1)
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
     * {@inheritDoc}
     */
    public function updateRow(RoleEntityInterface $role)
    {
        // Check if entity has pre-update method
        if (method_exists($role, 'preUpdate')) {
            // Call a method
            call_user_func(array($role, 'preUpdate'));
        }
        
        // Extract data
        $data = $this->getHydrator()->extract($role);
        
        // Get update
        $update = $this->getUpdate();
        
        $update
            ->set($data)
            ->where(array(
                'id' => $role->getId(),
            ))
        ;
        
        // Prepare statement
        $statement = $this->getSql()->prepareStatementForSqlObject($update);
        
        // Execute statement
        return $statement->execute();
    }
}
