<?php

namespace Media\Mapper;

use Zend\Db\ResultSet\HydratingResultSet;

use Core\Mapper\AbstractMapper;
use Media\Entity\MediaEntityInterface;
use Media\Entity\VoteEntityInterface;
use User\Entity\UserEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class VoteMapper extends AbstractMapper implements VoteMapperInterface
{
    /**
     * Count points for given media.
     * 
     * @param \Media\Entity\MediaEntityInterface $media
     * 
     * @return int
     */
    public function countByMedia(MediaEntityInterface $media)
    {
        // Up points
        $up = $this->selectAll(array(
            'media_id' => $media->getId(),
            'type'     => 'up',
        ));
        
        // Down points
        $down = $this->selectAll(array(
            'media_id' => $media->getId(),
            'type'     => 'down',
        ));
        
        // Return difference of points
        return count($up) - count($down);
    }
    
    /**
     * {@inheritDoc}
     */
    public function insertRow(VoteEntityInterface $vote)
    {
        // Check if entity has pre-insert method
        if (method_exists($vote, 'preInsert')) {
            // Call a method
            call_user_func(array($vote, 'preInsert'));
        }
        
        // Extract data
        $data = $this->getHydrator()->extract($vote);
        
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
        $vote->setId($result->getGeneratedValue());
        
        // Return result
        return $result;
    }
    
    /**
     * Insert or update vote.
     * 
     * @param \Media\Entity\MediaEntityInterface $media
     * @param \User\Entity\UserEntityInterface   $user
     * @param string                             $type
     * 
     * @return mixed
     */
    public function insertOrUpdate(VoteEntityInterface $vote)
    {
        // Set where
        $where = array(
            'media_id' => $vote->getMediaId(),
            'user_id'  => $vote->getUserId(),
        );
        
        // Get a row
        $row = $this->selectRow($where);
        
        // Check if no match exists
        if (empty($row) === true) {
            // Insert a row
            return $this->insertRow($vote);
        }
        
        // Change row data
        $row->setType($vote->getType());
        
        // Update a row
        return $this->updateRow($row);
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
        
        // Get result set
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
        
        // Get result set
        $resultSet = new HydratingResultSet(
            $this->getHydrator(),
            $this->getEntityClass()
        );
        
        $resultSet->initialize($stmt->execute());
        
        // Return result
        return $resultSet->current();
    }
    
    /**
     * Select vote by media.
     * 
     * @param \Media\Entity\MediaEntityInterface $media
     * @param \User\Entity\UserEntityInterface   $user
     * 
     * @return mixed
     */
    public function selectRowByMedia(MediaEntityInterface $media, UserEntityInterface $user)
    {
        return $this->selectRow(array(
            'media_id' => $media->getId(),
            'user_id'  => $user->getId(),
        ));
    }
    
    /**
     * Update a row.
     * 
     * @param array $values
     * @param array $where
     * 
     * @return mixed
     */
    public function updateRow(VoteEntityInterface $vote)
    {
        // Check if entity has pre-update method
        if (method_exists($vote, 'preUpdate')) {
            // Call a method
            call_user_func(array($vote, 'preUpdate'));
        }
        
        // Extract data
        $data = $this->getHydrator()->extract($vote);
        
        // Get update
        $update = $this->getUpdate();
        
        $update
            ->set($data)
            ->where(array(
                'id' => $vote->getId(),
            ))
        ;
        
        // Prepare statement
        $statement = $this->getSql()->prepareStatementForSqlObject($update);
        
        // Execute statement
        return $statement->execute();
    }
}