<?php

namespace Media\InputFilter;

use Category\Mapper\CategoryMapperInterface;
use Core\InputFilter\AbstractFilter;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class CategoryFilter extends AbstractFilter
{
    /**
     * @var \Category\Mapper\CategoryMapperInterface
     */
    protected $categoryMapper;
    
    /**
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        parent::__construct($options);
        
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
        // Check if category mapper is empty
        if ($this->categoryMapper === null) {
            // Set category mapper
            $this->setCategoryMapper($this->getOption('category_mapper'));
        }
        
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