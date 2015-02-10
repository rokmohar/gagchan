<?php

namespace Security\Mapper;

use Zend\Db\ResultSet\HydratingResultSet;

use Core\Mapper\AbstractMapper;
use Security\Entity\RoleEntityInterface;
use User\Entity\UserEntityInterface;

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
    
    /**
     * {@inheritDoc}
     */
    public function insertRole(UserEntityInterface $user, RoleEntityInterface $role)
    {
        // Get insert
        $insert = $this->getInsert('user_has_role'); // @todo: Make configurable
        $insert->values(array(
            'user_id' => $user->getId(),
            'role_id' => $role->getId(),
        ));
        
        // Prepare statement
        $statement = $this->getSql()->prepareStatementForSqlObject($insert);
        
        // Execute statement
        $result = $statement->execute();
        
        // Return result
        return $result;
    }
    
    /**
     * {@inheritDoc}
     */
    public function deleteRole(UserEntityInterface $user, RoleEntityInterface $role)
    {
        // Get delete
        $delete = $this->getDelete('user_has_role'); // @todo: Make configurable
        $delete->where(array(
            'user_id' => $user->getId(),
            'role_id' => $role->getId(),
        ));
        
        // Prepare statement
        $statement = $this->getSql()->prepareStatementForSqlObject($delete);
        
        // Execute statement
        $result = $statement->execute();
        
        // Return result
        return $result;
    }
    
    /**
     * {@inheritDoc}
     */
    public function selectByUser(UserEntityInterface $user)
    {
        // Get select
        $select = $this->getSelect();
        $select
            ->join('user_has_role', sprintf('%s.id = %s.role_id',
                $this->getTableName(),
                'user_has_role'
            )) // @todo: Make configurable
            ->where(array(
                'user_id' => $user->getId(),
            ))    
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
}
