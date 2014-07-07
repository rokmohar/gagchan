<?php

namespace Core\Mapper;

use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\Db\Sql\Sql;

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
     * @var \Zend\Db\Sql\Sql
     */
    protected $sql;
    
    /**
     * @var String
     */
    protected $tableName;
    
    /**
     * @param \Zend\Db\Adapter\Adapter
     * @param String
     */
    public function __construct(DbAdapter $dbAdapter, $tableName)
    {
        if (is_string($tableName) === false) {
            throw new \InvalidArgumentException(
                printf("Expected a string, %s given.", gettype($tableName))
            );
        }
        
        $this->dbAdapter = $dbAdapter;
        $this->tableName = $tableName;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getDbAdapter()
    {
        return $this->dbAdapter;
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
}
