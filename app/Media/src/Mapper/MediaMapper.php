<?php

namespace Media\Mapper;

use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;

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
        
        // Get SQL
        $sql = $this->getSql();
        
        // Execute statemet
        $result = $sql->prepareStatementForSqlObject($select)->execute();
        
        // Check if no entry exists
        return ($result->count() === 0);
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
     * Return a list of media by category identifier.
     * 
     * @param Integer $categoryId
     * 
     * @return mixed
     */
    public function selectByCategory($categoryId)
    {
        return $this->selectAll(array(
            'category_id' => $categoryId,
        ));
    }
    
    /**
     * Select results for pagination.
     * 
     * @param Array $where
     * 
     * @return mixed
     */
    public function selectPagination(array $where = array())
    {
        // Get select
        $select = $this->getSelect();
        
        $select
            ->where($where)
        ;
        
        // Get hydrating result set
        $resultSet = new HydratingResultSet(
            $this->getHydrator(),
            $this->getEntityClass()
        );
        
        // Get paginator select adapter
        $adapter = new DbSelect($select, $this->getDbAdapter(), $resultSet);
        
        // Return paginator
        return new Paginator($adapter); 
    }
    
    /**
     * {@inheritDoc}
     */
    public function selectOne(array $where = array())
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