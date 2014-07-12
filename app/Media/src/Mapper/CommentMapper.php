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
     * @param Integer $mediaId
     * @param Integer $userId
     * @param String  $comment
     */
    public function insertOne($mediaId, $userId, $comment)
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
     * Return a list of media.
     * 
     * @param Array $where
     * 
     * @return mixed
     */
    public function selectAll(array $where)
    {
        // Get select
        $select = $this->getSelect();
        
        $select
            ->where($where)
            ->order('media_comment.created_at DESC')
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
}