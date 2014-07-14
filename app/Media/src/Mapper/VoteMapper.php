<?php

namespace Media\Mapper;

use Zend\Db\ResultSet\HydratingResultSet;

use Core\Mapper\AbstractMapper;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class VoteMapper extends AbstractMapper implements VoteMapperInterface
{
    /**
     * Count points for given mediaidentifier.
     * 
     * @param Integer $media_id
     * 
     * @return Integer
     */
    public function countByMedia($media_id)
    {
        // Positive points
        $up = $this->selectAll(array(
            'media_id' => $media_id,
            'type'     => 'up',
        ));
        
        // Negative points
        $down = $this->selectAll(array(
            'media_id' => $media_id,
            'type'     => 'down',
        ));
        
        // Return difference of points
        return count($up) - count($down);
    }
    
    /**
     * Insert vote to database.
     * 
     * @param Integer $mediaId
     * @param Integer $userId
     * @param String  $type
     * 
     * @return mixed
     */
    public function insertRow($mediaId, $userId, $type)
    {
        // Get insert
        $insert = $this->getInsert();
        
        $insert
            ->values(array(
                'media_id' => $mediaId,
                'user_id'  => $userId,
                'type'     => $type,
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
     * Insert or update vote.
     * 
     * @param Integer $mediaId
     * @param Integer $userId
     * @param String  $type
     * 
     * @return mixed
     */
    public function insertOrUpdate($mediaId, $userId, $type)
    {
        // Set where
        $where = array(
            'media_id' => $mediaId,
            'user_id'  => $userId,
        );
        
        // Get row
        $row = $this->selectRow($where);
        
        // Check if row exists
        if (empty($row) === true) {
            // Insert new row
            return $this->insertRow($mediaId, $userId, $type);
        }
        
        // Check if type has not changed
        if ($row->getType() === $type) {
            // Return row
            return $row;
        }
        
        // Update row
        return $this->updateRow(
            array(
                'user_id' => $userId,
                'type'    => $type,
            ),
            $where
        );
    }
    
    /**
     * {@inheritDoc}
     */
    public function selectAll(array $where = array())
    {
        // Get select
        $select = $this->getSelect();
        
        $select
            ->where($where)
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
    public function selectRow(array $where = array())
    {
        // Get select
        $select = $this->getSelect();
        
        $select
            ->where($where)
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
     * Select vote by media identitifer.
     * 
     * @param Integer $mediaId
     * @param Integer $userId
     * 
     * @return mixed
     */
    public function selectRowByMedia($mediaId, $userId)
    {
        return $this->selectRow(array(
            'media_id' => $mediaId,
            'user_id'  => $userId,
        ));
    }
    
    /**
     * Update row.
     * 
     * @param Array $values
     * @param Array $where
     * 
     * @return mixed
     */
    public function updateRow(array $values, array $where = array())
    {
        // Get update
        $update = $this->getUpdate();
        
        $update
            ->set($values)
            ->where($where)
        ;
        
        // Get SQL
        $sql = $this->getSql();
        
        // Prepare and execute statement
        $result = $sql->prepareStatementForSqlObject($update)->execute();
        
        // Return result
        return $result;
    }
}