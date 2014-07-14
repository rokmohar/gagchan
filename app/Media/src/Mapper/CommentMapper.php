<?php

namespace Media\Mapper;

use Zend\Db\ResultSet\HydratingResultSet;

use Core\Mapper\AbstractMapper;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class CommentMapper extends AbstractMapper implements CommentMapperInterface
{
    /**
     * Count comments for given media.
     * 
     * @param Integer $media_id
     * 
     * @return Integer
     */
    public function countByMedia($media_id)
    {
        // Select comments
        $result = $this->selectAll(array(
            'media_id' => $media_id,
        ));
        
        // Return number of comments
        return count($result);
    }
    
    /**
     * @param Integer $mediaId
     * @param Integer $userId
     * @param String  $comment
     */
    public function insertRow($mediaId, $userId, $comment)
    {
        // Get SQL insert
        $insert = $this->getInsert();
        
        $insert
            ->values(array(
                'media_id' => $mediaId,               
                'user_id'  => $userId,
                'comment'  => $comment,
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
     * {@inheritDoc}
     */
    public function selectAll(array $where)
    {
        // Get select
        $select = $this->getSelect();
        
        $select
            ->where($where)
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
     * Return a list of media.
     * 
     * @param Integer $mediaId
     * 
     * @return mixed
     */
    public function selectByMedia($mediaId)
    {
        return $this->selectAll(array(
            'media_id' => $mediaId,
        ));
    }
    
    /**
     * {@inheritDoc}
     */
    public function selectRow(array $where)
    {
        // Get select
        $select = $this->getSelect();
        
        $select
            ->where($where)
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
        return $resultSet->current();;
    }
}