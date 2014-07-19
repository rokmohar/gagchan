<?php

namespace Core\Mapper;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface MapperInterface
{
    /**
     * Return the database adapter.
     * 
     * @return \Zend\Db\Adapter\Adapter
     */
    public function getDbAdapter();
    
    /**
     * Return the entity class.
     * 
     * @return String
     */
    public function getEntityClass();
    
    /**
     * Return the hydrator.
     * 
     * @return \Zend\Stdlib\Hydrator\HydratorInterface
     */
    public function getHydrator();
    
    /**
     * Return the SQL.
     * 
     * @return \Zend\Db\Sql\Sql
     */
    public function getSql();
    
    /**
     * Return the table name.
     * 
     * @return String
     */
    public function getTableName();
}
