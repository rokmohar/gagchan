<?php

namespace Media\Mapper;

use Zend\Db\ResultSet\HydratingResultSet;

use Core\Mapper\AbstractMapper;
use Media\Entity\CommentEntityInterface;
use Media\Entity\MediaEntityInterface;
use User\Entity\UserEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class CommentMapper extends AbstractMapper implements CommentMapperInterface
{
    /**
     * Count comments for media.
     * 
     * @param \Media\Entity\MediaEntityInterface $media
     * 
     * @return int
     */
    public function countByMedia(MediaEntityInterface $media)
    {
        // Select comments
        $result = $this->selectAll(array(
            'media_id' => $media->getId(),
        ));
        
        // Return number of comments
        return count($result);
    }
    
    /**
     * Count comments for user.
     * 
     * @param \User\Entity\UserEntityInterface $user
     * 
     * @return int
     */
    public function countByUser(UserEntityInterface $user)
    {
        // Select comments
        $result = $this->selectAll(array(
            'user_id' => $user->getId(),
        ));
        
        // Return number of comments
        return count($result);
    }
    
    /**
     * {@inheritDoc}
     */
    public function insertRow(CommentEntityInterface $comment)
    {
        // Check if entity has pre-insert method
        if (method_exists($comment, 'preInsert')) {
            // Call a method
            call_user_func(array($comment, 'preInsert'));
        }
        
        // Get SQL insert
        $insert = $this->getInsert();
        
        $insert
            ->values(array(
                'media_id'   => $comment->getMediaId(),               
                'user_id'    => $comment->getUserId(),
                'comment'    => $comment->getComment(),
                'created_at' => $comment->getCreatedAt()->format('Y-m-d H:i:s'),
                'updated_at' => $comment->getUpdatedAt()->format('Y-m-d H:i:s'),
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
     * Return comments by media.
     * 
     * @param \Media\Entity\MediaEntityInterface $media
     * 
     * @return mixed
     */
    public function selectByMedia(MediaEntityInterface $media)
    {
        return $this->selectAll(array(
            'media_id' => $media->getId(),
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
        
        // Execute the statement
        $resultSet = new HydratingResultSet(
            $this->getHydrator(),
            $this->getEntityClass()
        );
        
        $resultSet->initialize($stmt->execute());
        
        // Return result
        return $resultSet->current();;
    }
    
    /**
     * {@inheritDoc}
     */
    public function updateRow(CommentEntityInterface $comment)
    {
        // Check if entity has pre-update method
        if (method_exists($comment, 'preUpdate')) {
            // Call a method
            call_user_func(array($comment, 'preUpdate'));
        }
        
        // Get update
        $update = $this->getUpdate();
        
        $update
            ->set(array(
                'media_id'   => $comment->getMediaId(),
                'user_id'    => $comment->getUserId(),
                'comment'    => $comment->getComment(),
                'updated_at' => $comment->getUpdatedAt()->format('Y-m-d H:i:s'),
            ))
            ->where(array(
                'id' => $comment->getId(),
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