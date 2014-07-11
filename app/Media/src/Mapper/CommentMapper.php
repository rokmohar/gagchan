<?php

namespace Media\Mapper;

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
        
        // Prepare SQL statement
        $this->getSql()->prepareStatementForSqlObject($insert)->execute();
        
        return $this;
    }
    
    /**
     * Return a list of media.
     * 
     * @param Array $where
     * 
     * @return mixed
     */
    public function selectAllBy(array $where)
    {
        // Get select
        $select = $this->getSelect();
        
        $select
            ->where($where)
            ->order('media_comment.created_at DESC')
        ;
        
        // Get SQL
        $sql = $this->getSql();
        
        // Execute statement
        return $sql->prepareStatementForSqlObject($select)->execute();
    }
    
    /**
     * Return a list of media.
     * 
     * @param Integer $mediaId
     * 
     * @return mixed
     */
    public function selectAllByMedia($mediaId)
    {
        return $this->selectAllBy(array(
            'media_id' => $mediaId,
        ));
    }
}