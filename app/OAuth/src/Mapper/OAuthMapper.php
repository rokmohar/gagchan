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
        
        // Get SQL insert
        $insert = $this->getInsert();
        
        $insert
            ->values(array(
                'user_id'     => $oauth->getUserId(),
                'provider'    => $oauth->getProvider(),
                'provider_id' => $oauth->getProviderId(),
                'created_at'  => $oauth->getCreatedAt()->format('Y-m-d H:i:s'),
                'updated_at'  => $oauth->getUpdatedAt()->format('Y-m-d H:i:s'),
            ))
        ;
        
        // Get SQL
        $sql = $this->getSql();
        
        // Prepare statement
        $statement = $sql->prepareStatementForSqlObject($insert);
        
        // Execute statement
        $result = $statement->execute();
        
        // Set generated value
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
        
        // Get update
        $update = $this->getUpdate();
        
        $update
            ->set(array(
                'user_id'     => $oauth->getUserId(),
                'provider'    => $oauth->getProvider(),
                'provider_id' => $oauth->getProviderId(),
                'updated_at'  => $oauth->getUpdatedAt()->format('Y-m-d H:i:s'),
            ))
            ->where(array(
                'id' => $oauth->getId(),
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