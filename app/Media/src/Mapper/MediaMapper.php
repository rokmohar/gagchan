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
     * Insert a row.
     * 
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
    public function insertRow($slug, $name, $reference, $userId, $categoryId, $width, $height, $size, $contentType)
    {
        // Get insert
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
        
        // Get SQL
        $sql = $this->getSql();
        
        // Prepare and execute statement
        $result = $sql->prepareStatementForSqlObject($insert)->execute();
        
        // Return result
        return $result;
    }
        
    /**
     * @return Boolean
     */
    public function isUniqueSlug($slug)
    {
        // Get select
        $select = $this->getSelect();
        
        $select
            ->columns(array('id'))
            ->where(array(
                'slug' => $slug,
            ))
        ;
        
        // Get SQL
        $sql = $this->getSql();
        
        // Prepare and execute statement
        $result = $sql->prepareStatementForSqlObject($select)->execute();
        
        // Check if no entry exists
        return (count($result) === 0);
    }
    
    /**
     * {@inheritDoc}
     */
    public function selectAll(array $where = array(), array $order = array(), $limit = false)
    {
        // Get select
        $select = $this->getSelect();
        
        $select
            ->where($where)
            ->order($order)
        ;
        
        // Check if limit given
        if (is_int($limit)) {
            // Add limit
            $select->limit($limit);
        }
        
        // Get result set
        $resultSet = new HydratingResultSet(
            $this->getHydrator(),
            $this->getEntityClass()
        );
        
        // Get select for paginator
        $adapter = new DbSelect($select, $this->getDbAdapter(), $resultSet);
        
        // Return paginator
        return new Paginator($adapter); 
    }
    
    /**
     * Select featured media.
     * 
     * @return mixed
     */
    public function selectFeatured()
    {
        return $this->selectAll(
            array(
                'is_featured' => 1,
            ),
            array('created_at DESC'),
            10
        );
    }
    
    /**
     * Select latest media.
     * 
     * @return mixed
     */
    public function selectLatest()
    {
        return $this->selectAll(array(), array('created_at DESC'));
    }
    
    /**
     * Select latest media.
     * 
     * @param Integer $categoryId
     * 
     * @return mixed
     */
    public function selectLatestByCategory($categoryId)
    {
        return $this->selectAll(
            array(
                'category_id' => $categoryId,
            ),
            array('created_at DESC')
        );
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
     * Select media by identifier.
     * 
     * @param Integer $id
     * 
     * @return mixed
     */
    public function selectRowById($id)
    {
        return $this->selectRow(array(
            'id' => $id,
        ));
    }
    
    /**
     * Select media by unique slug.
     * 
     * @param String $slug
     * 
     * @return mixed
     */
    public function selectRowBySlug($slug)
    {
        return $this->selectRow(array(
            'slug' => $slug,
        ));
    }
}