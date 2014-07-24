<?php

namespace User\Mapper;

use Zend\Db\ResultSet\HydratingResultSet;

use Core\Mapper\AbstractMapper;
use User\Entity\UserEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class UserMapper extends AbstractMapper implements UserMapperInterface
{
    /**
     * {@inheritDoc}
     */
    public function insertRow(UserEntityInterface $user)
    {
        // Check if entity has pre-insert method
        if (method_exists($user, 'preInsert')) {
            // Call a method
            call_user_func(array($user, 'preInsert'));
        }
        
        // Extract data
        $data = $this->getHydrator()->extract($user);
        
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
        $user->setId($result->getGeneratedValue());
        
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
     * Select user by the identifier.
     * 
     * @param string $id
     */
    public function selectRowById($id)
    {
        return $this->selectRow(array(
            'id' => $id,
        ));
    }
    
    /**
     * Select user by the username.
     * 
     * @param string $username
     */
    public function selectRowByUsername($username)
    {
        return $this->selectRow(array(
            'username' => $username,
        ));
    }
    
    /**
     * Select user by the email address.
     * 
     * @param string $email
     */
    public function selectRowByEmail($email)
    {
        return $this->selectRow(array(
            'email' => $email,
        ));
    }
    
    /**
     * {@inheritDoc}
     */
    public function updateRow(UserEntityInterface $user)
    {
        // Check if entity has pre-update method
        if (method_exists($user, 'preUpdate')) {
            // Call a method
            call_user_func(array($user, 'preUpdate'));
        }
        
        // Extract data
        $data = $this->getHydrator()->extract($user);
        
        // Get update
        $update = $this->getUpdate();
        
        $update
            ->set($data)
            ->where(array(
                'id' => $user->getId(),
            ))
        ;
        
        // Prepare statement
        $statement = $this->getSql()->prepareStatementForSqlObject($update);
        
        // Execute statement
        return $statement->execute();
    }
}