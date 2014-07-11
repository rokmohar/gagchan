<?php

namespace Media\View\Helper;

use Zend\View\Helper\AbstractHelper;

use Media\Mapper\CategoryMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class CategoryHelper extends AbstractHelper
{
    /**
     * @var \Media\Mapper\CategoryMapperInterface
     */
    protected $categoryMapper;
    
    /**
     * @param \Media\Mapper\CategoryMapperInterface $categoryMapper
     */
    public function __construct(CategoryMapperInterface $categoryMapper)
    {
        $this->categoryMapper = $categoryMapper;
    }
    
    /**
     * __invoke
     *
     * @return \ZfcUser\Entity\UserInterface
     */
    public function __invoke()
    {
        return $this;
    }
    
    /**
     * Return a list of categories.
     * 
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categoryMapper->selectAll();
    }
}