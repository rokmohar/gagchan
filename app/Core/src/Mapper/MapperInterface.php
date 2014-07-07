<?php

namespace Core\Mapper;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
interface MapperInterface
{
    /**
     * @return \Zend\Db\Adapter\Adapter
     */
    public function getDbAdapter();
    
    /**
     * @return \Zend\Db\Sql\Sql
     */
    public function getSql();
    
    /**
     * @return String
     */
    public function getTableName();
}
