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
     * @var String
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
     * @var String
     */
    protected $tableName;
    
    /**
     * @param \Zend\Db\Adapter\Adapter                $dbAdapter
     * @param String                                  $tableName
     * @param String                                  $entityClass
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
    public function getDelete()
    {
        return $this->getSql()->delete($this->getTableName());
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
    public function getInsert()
    {
        return $this->getSql()->insert($this->getTableName());
    }
    
    /**
     * @return \Zend\Db\Sql\Select;
     */
    public function getSelect()
    {
        return $this->getSql()->select($this->getTableName());
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
    public function getUpdate()
    {
        return $this->getSql()->update($this->getTableName());
    }
}
