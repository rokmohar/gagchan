<?php

namespace User\Mapper;

use Zend\Db\ResultSet\HydratingResultSet;

use Core\Mapper\AbstractMapper;
use User\Entity\ConfirmationEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class ConfirmationMapper extends AbstractMapper implements ConfirmationMapperInterface
{
    /**
     * {@inheritDoc}
     */
    public function insertRow(ConfirmationEntityInterface $confirmation)
    {
        // Check if entity has pre-insert method
        if (method_exists($confirmation, 'preInsert')) {
            // Call a method
            call_user_func(array($confirmation, 'preInsert'));
        }
        
        // Extract data
        $data = $this->getHydrator()->extract($confirmation);
        
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
        $confirmation->setId($result->getGeneratedValue());
        
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
     * Select a row by the request token.
     * 
     * @param
     */
    public function selectNotConfirmed($id, $requestToken)
    {
        return $this->selectRow(array(
            'id'            => $id,
            'request_token' => $requestToken,
            'is_confirmed'  => false,
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function updateRow(ConfirmationEntityInterface $confirmation)
    {
        // Check if entity has pre-update method
        if (method_exists($confirmation, 'preUpdate')) {
            // Call a method
            call_user_func(array($confirmation, 'preUpdate'));
        }
        
        // Extract data
        $data = $this->getHydrator()->extract($confirmation);
        
        // Get update
        $update = $this->getUpdate();
        
        $update
            ->set($data)
            ->where(array(
                'id' => $confirmation->getId(),
            ))
        ;
        
        // Prepare statement
        $statement = $this->getSql()->prepareStatementForSqlObject($update);
        
        // Execute statement
        return $statement->execute();
    }
}