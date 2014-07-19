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
        
        // Get SQL insert
        $insert = $this->getInsert();
        
        $insert
            ->values(array(
                'username'   => $user->getUsername(),
                'email'      => $user->getEmail(),               
                'password'   => $user->getPassword(),
                'created_at' => $user->getCreatedAt()->format('Y-m-d H:i:s'),
                'updated_at' => $user->getUpdatedAt()->format('Y-m-d H:i:s'),
            ))
        ;
        
        // Get SQL
        $sql = $this->getSql();
        
        // Prepare statement
        $statement = $sql->prepareStatementForSqlObject($insert);
        
        // Execute statement
        return $statement->execute();
    }
    
    /**
     * Select user by the email address.
     * 
     * @param array $where
     * @param array $order
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
     * @param String $id
     */
    public function selectRowById($id)
    {
        return $this->selectRow(array(
            'id' => $id,
        ));
    }
    
    /**
     * Select user by the email address.
     * 
     * @param String $email
     */
    public function selectRowByEmail($email)
    {
        return $this->selectRow(array(
            'email' => $email,
        ));
    }
}