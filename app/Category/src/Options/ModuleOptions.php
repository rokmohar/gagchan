<?php

namespace Category\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class ModuleOptions extends AbstractOptions
{
    /**
     * @var Boolean
     */
    protected $__strictMode__ = false;
    
    /**
     * @var String
     */
    protected $categoryEntity = 'Category\Entity\CategoryEntity';
    
    /**
     * @var String
     */
    protected $categoryHydrator = 'Category\Hydrator\CategoryHydrator';
    
    /**
     * @var String
     */
    protected $categoryMapper = 'Category\Mapper\CategoryMapper';
    
    /**
     * @return String
     */
    public function getCategoryEntity()
    {
        return $this->categoryEntity;
    }
    
    /**
     * @return String
     */
    public function getCategoryHydrator()
    {
        return $this->categoryHydrator;
    }
    
    /**
     * @return String
     */
    public function getCategoryMapper()
    {
        return $this->categoryMapper;
    }
}