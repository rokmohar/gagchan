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
     * @var bool
     */
    protected $__strictMode__ = false;
    /**
     * @var string
     */
    protected $categoryEntity = 'Category\Entity\CategoryEntity';
    /**
     * @var string
     */
    protected $categoryHydrator = 'Category\Hydrator\CategoryHydrator';
    /**
     * @var string
     */
    protected $categoryMapper = 'Category\Mapper\CategoryMapper';
    /**
     * @return string
     */
    public function getCategoryEntity()
    {
        return $this->categoryEntity;
    }
    /**
     * @return string
     */
    public function getCategoryHydrator()
    {
        return $this->categoryHydrator;
    }
    /**
     * @return string
     */
    public function getCategoryMapper()
    {
        return $this->categoryMapper;
    }
}