<?php

namespace Media\Mapper;

use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;

use Core\Mapper\AbstractMapper;
use Category\Entity\CategoryEntityInterface;
use Media\Entity\MediaEntityInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class MediaMapper extends AbstractMapper implements MediaMapperInterface
{
    /**
     * {@inheritDoc}
     */
    public function insertRow(MediaEntityInterface $media)
    {
        // Check if entity has pre-insert method
        if (method_exists($media, 'preInsert')) {
            // Call a method
            call_user_func(array($media, 'preInsert'));
        }
        
        // Extract data
        $data = $this->getHydrator()->extract($media);
        
        // Get SQL insert
        $insert = $this->getInsert();
        
        $insert
            ->values($data)
        ;
        
        // Prepare statement
        $statement = $this->getSql()->prepareStatementForSqlObject($insert);
        
        // Execute statement
        $result = $statement->execute();
        
        // Set identifier
        $media->setId($result->getGeneratedValue());
        
        // Return result
        return $result;
    }
    
    /**
     * @param \Media\Entity\MediaEntityInterface $media
     * 
     * @return bool
     */
    public function hasUniqueSlug(MediaEntityInterface $media)
    {
        return $this->isUniqueSlug($media->getSlug());
    }
    
    /**
     * @param string $slug
     * 
     * @return bool
     */
    public function isUniqueSlug($slug)
    {
        // Check if no match exists
        return (empty($this->selectRow(array('slug' => $slug))) === true);
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
     * Select rows by category.
     * 
     * @param \Category\Entity\CategoryEntityInterface $category
     * 
     * @return mixed
     */
    public function selectByCategory(CategoryEntityInterface $category)
    {
        return $this->selectAll(array(
            'category_id' => $category->getId(),
        ));
    }
    
    /**
     * Select featured rows.
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
     * Select latest rows.
     * 
     * @return mixed
     */
    public function selectLatest()
    {
        return $this->selectAll(array(), array('created_at DESC'));
    }
    
    /**
     * Select latest rows by category.
     * 
     * @param \Category\Entity\CategoryEntityInterface $category
     * 
     * @return mixed
     */
    public function selectLatestByCategory(CategoryEntityInterface $category)
    {
        return $this->selectAll(
            array(
                'category_id' => $category->getId(),
            ),
            array('created_at DESC')
        );
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
     * Select row by media.
     * 
     * @param int $id
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
     * @param string $slug
     * 
     * @return mixed
     */
    public function selectRowBySlug($slug)
    {
        return $this->selectRow(array(
            'slug' => $slug,
        ));
    }
    
    /**
     * {@inheritDoc}
     */
    public function updateRow(MediaEntityInterface $media)
    {
        // Check if entity has pre-update method
        if (method_exists($media, 'preUpdate')) {
            // Call a method
            call_user_func(array($media, 'preUpdate'));
        }
        
        // Extract data
        $data = $this->getHydrator()->extract($media);
        
        // Get update
        $update = $this->getUpdate();
        
        $update
            ->set($data)
            ->where(array(
                'id' => $media->getId(),
            ))
        ;
        
        // Prepare statement
        $statement = $this->getSql()->prepareStatementForSqlObject($update);
        
        // Execute statement
        return $statement->execute();
    }
}