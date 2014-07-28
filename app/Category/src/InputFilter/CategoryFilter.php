<?php

namespace Media\InputFilter;

use Zend\InputFilter\InputFilter;

use Category\Mapper\CategoryMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class CategoryFilter extends InputFilter
{
    /**
     * @var \Category\Mapper\CategoryMapperInterface
     */
    protected $categoryMapper;
    
    /**
     * @param \Category\Mapper\CategoryMapperInterface $categoryMapper
     */
    public function __construct(CategoryMapperInterface $categoryMapper)
    {
        // Set category mapper
        $this->setCategoryMapper($categoryMapper);
        
        // Add form elements
        $this
            ->addSlug()
            ->addName()
            ->addPriority()
        ;
    }
    
    /**
     * Add filter for the slug element.
     * 
     * @return \Category\InputFilter\CategoryFilter
     */
    protected function addSlug()
    {
        $this->add(array(
            'name'       => 'slug',
            'required'   => true,
            'validators' => array(
                array(
                    'name'    => 'Zend\Validator\Regex',
                    'options' => array(
                        'pattern'  => '/^[a-zA-Z0-9\-]*$/',
                    ),
                ),
            ),
            'filters'   => array(
                array('name' => 'Zend\Filter\HtmlEntities'),
                array('name' => 'Zend\Filter\StringTrim'),
                array('name' => 'Zend\Filter\StripTags'),
            ),
        ));
    }
    
    /**
     * Add filter for the name element.
     * 
     * @return \Category\InputFilter\CategoryFilter
     */
    protected function addName()
    {
        $this->add(array(
            'name'      => 'name',
            'required'  => true,
            'filters'   => array(
                array('name' => 'Zend\Filter\HtmlEntities'),
                array('name' => 'Zend\Filter\StringTrim'),
                array('name' => 'Zend\Filter\StripTags'),
            ),
        ));
    }
    
    /**
     * Add filter for the priority element.
     * 
     * @return \Category\InputFilter\CategoryFilter
     */
    protected function addPriority()
    {
        $this->add(array(
            'name'      => 'priority',
            'required'  => true,
            'filters'   => array(
                array('name' => 'Zend\Filter\Int'),
            ),
        ));
    }
    
    /**
     * Return the category mapper.
     * 
     * @return \Category\Mapper\CategoryMapperInterface
     */
    public function getCategoryMapper()
    {
        return $this->categoryMapper;
    }
    
    /**
     * Set the category mapper.
     * 
     * @param \Category\Mapper\CategoryMapperInterface $categoryMapper
     */
    public function setCategoryMapper(CategoryMapperInterface $categoryMapper)
    {
        $this->categoryMapper = $categoryMapper;
        
        return $this;
    }
}