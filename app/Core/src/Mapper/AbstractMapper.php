<?php

namespace Core\Mapper;

use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\Db\Sql\Sql;
use Zend\Stdlib\Hydrator\HydratorInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
abstract class AbstractMapper implements MapperInterface
{
    /**
     * @var \Zend\Db\Adapter\Adapter
     */
    protected $dbAdapter;
    
    /**
     * @var string
     */
    protected $entityClass;
    
    /**
     * @var \Zend\Stdlib\Hydrator\HydratorInterface
     */
    protected $hydrator;
    
    /**
     * @var \Zend\Db\Sql\Sql
     */
    protected $sql;
    
    /**
     * @var string
     */
    protected $tableName;
    
    /**
     * @param \Zend\Db\Adapter\Adapter                $dbAdapter
     * @param string                                  $tableName
     * @param string                                  $entityClass
     * @param \Zend\Stdlib\Hydrator\HydratorInterface $hydrator
     */
    public function __construct(
        DbAdapter $dbAdapter,
        $tableName,
        $entityClass = null,
        HydratorInterface $hydrator = null
    ) {
        $this->dbAdapter   = $dbAdapter;
        $this->tableName   = $tableName;
        $this->entityClass = $entityClass;
        $this->hydrator    = $hydrator;
    }
    
    /**
     * @return \Zend\Db\Sql\Delete;
     */
    public function getDelete($tableName = NULL)
    {
        return $this->getSql()->delete($tableName ?: $this->getTableName());
    }
    
    /**
     * {@inheritDoc}
     */
    public function getDbAdapter()
    {
        return $this->dbAdapter;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getEntityClass()
    {
        return $this->entityClass;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getHydrator()
    {
        return $this->hydrator;
    }
    
    /**
     * @return \Zend\Db\Sql\Insert;
     */
    public function getInsert($tableName = NULL)
    {
        return $this->getSql()->insert($tableName ?: $this->getTableName());
    }
    
    /**
     * @return \Zend\Db\Sql\Select;
     */
    public function getSelect($tableName = NULL)
    {
        return $this->getSql()->select($tableName ?: $this->getTableName());
    }
    
    /**
     * {@inheritDoc}
     */
    public function getSql()
    {
        if ($this->sql === null) {
            return $this->sql = new Sql($this->getDbAdapter());
        }
        
        return $this->sql;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getTableName()
    {
        return $this->tableName;
    }
    
    /**
     * @return \Zend\Db\Sql\Update;
     */
    public function getUpdate($tableName = NULL)
    {
        return $this->getSql()->update($tableName ?: $this->getTableName());
    }
}
