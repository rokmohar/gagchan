<?php
namespace Category\View\Helper;
use Zend\View\Helper\AbstractHelper;
use Category\Mapper\CategoryMapperInterface;
/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
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
     * {@inheritDoc}
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