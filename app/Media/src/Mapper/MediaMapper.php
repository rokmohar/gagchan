<?php

namespace Media\Mapper;

use Core\Mapper\AbstractMapper;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class MediaMapper extends AbstractMapper implements MediaMapperInterface
{
    /**
     * @param String  $slug
     * @param String  $name
     * @param String  $reference
     * @param Integer $userId
     * @param Integer $categoryId
     * @param Integer $width
     * @param Integer $height
     * @param Integer $size
     * @param String  $contentType
     */
    public function insertOne($slug, $name, $reference, $userId, $categoryId, $width, $height, $size, $contentType)
    {
        // Get SQL insert
        $insert = $this->getInsert();
        
        $insert
            ->values(array(
                'slug'         => $slug,
                'name'         => $name,
                'reference'    => $reference,
                'user_id'      => $userId,
                'category_id'  => $categoryId,
                'width'        => $width,
                'height'       => $height,
                'size'         => $size,
                'content_type' => $contentType,
            ))
        ;
        
        // Prepare SQL statement
        $this->getSql()->prepareStatementForSqlObject($insert)->execute();
        
        return $this;
    }
        
    /**
     * @return Boolean
     */
    public function isUniqueSlug($slug)
    {
        // Get SQL select
        $select = $this->getSelect();
        
        $select
            ->columns(array('id'))
            ->where(array(
                'slug' => $slug,
            ))
        ;
        
        // Execute statemet
        $result = $this->getSql()->prepareStatementForSqlObject($select)->execute();
        
        // Return true if slug does not exist
        return ($result->count() === 0);
    }
    
    /**
     * Return a list of media.
     * 
     * @return mixed
     */
    public function selectAll()
    {
        // Get select
        $select = $this->getSelect();
        
        $select
            ->order('media.created_at DESC')
        ;
        
        // Get SQL
        $sql = $this->getSql();
        
        // Execute statement
        return $sql->prepareStatementForSqlObject($select)->execute();
    }
    
    /**
     * Select media from DB.
     * 
     * @param Array $where
     * 
     * @return mixed
     */
    public function selectOne(array $where)
    {
        // Get select
        $select = $this->getSelect();
        
        $select
            ->where($where)
            ->limit(1)
        ;
        
        // Get SQL
        $sql = $this->getSql();
        
        // Execute statement
        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }
    
    /**
     * Select media from DB.
     * 
     * @param Integer $id
     * 
     * @return mixed
     */
    public function selectOneById($id)
    {
        return $this->selectOne(array(
            'id' => $id,
        ));
    }
    
    /**
     * Select media from DB.
     * 
     * @param String $slug
     * 
     * @return mixed
     */
    public function selectOneBySlug($slug)
    {
        return $this->selectOne(array(
            'slug' => $slug,
        ));
    }
}