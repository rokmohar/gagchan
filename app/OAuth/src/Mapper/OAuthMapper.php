<?php

namespace OAuth\Mapper;

use Zend\Db\ResultSet\HydratingResultSet;

use Core\Mapper\AbstractMapper;
use OAuth\Entity\OAuthEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class OAuthMapper extends AbstractMapper implements OAuthMapperInterface
{
    /**
     * {@inheritDoc}
     */
    public function insertRow(OAuthEntityInterface $oauth)
    {
        // Check if entity has pre-insert method
        if (method_exists($oauth, 'preInsert')) {
            // Call a method
            call_user_func(array($oauth, 'preInsert'));
        }
        
        // Extract data
        $data = $this->getHydrator()->extract($oauth);
        
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
        $oauth->setId($result->getGeneratedValue());
        
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
     * Select rows by the user identifier.
     * 
     * @param int $userId
     */
    public function selectAllByUser($userId)
    {
        return $this->selectAll(array(
            'user_id' => $userId,
        ));
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
     * Select row by the provider.
     * 
     * @param int    $userId
     * @param string $provider
     */
    public function selectRowByProvider($userId, $provider)
    {
        return $this->selectRow(array(
            'user_id'  => $userId,
            'provider' => $provider,
        ));
    }
    
    /**
     * Select row by the provider identifier.
     * 
     * @param string $provider
     * @param string $providerId
     */
    public function selectRowByProviderId($provider, $providerId)
    {
        return $this->selectRow(array(
            'provider'    => $provider,
            'provider_id' => $providerId,
        ));
    }
    
    /**
     * {@inheritDoc}
     */
    public function updateRow(OAuthEntityInterface $oauth)
    {
        // Check if entity has pre-update method
        if (method_exists($oauth, 'preUpdate')) {
            // Call a method
            call_user_func(array($oauth, 'preUpdate'));
        }
        
        // Extract data
        $data = $this->getHydrator()->extract($oauth);
        
        // Get update
        $update = $this->getUpdate();
        
        $update
            ->set($data)
            ->where(array(
                'id' => $oauth->getId(),
            ))
        ;
        
        // Prepare statement
        $statement = $this->getSql()->prepareStatementForSqlObject($update);
        
        // Execute statement
        return $statement->execute();
    }
}