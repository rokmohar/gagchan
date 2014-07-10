<?php

namespace Media\Mapper;

use Core\Mapper\AbstractMapper;

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
    public function insertMedia($slug, $name, $reference, $userId, $categoryId, $width, $height, $size, $contentType)
    {
        // Get SQL insert
        $insert = $this->getSql()->insert($this->getTableName());
        
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
    
}