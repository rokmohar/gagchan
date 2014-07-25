<?php

namespace Category\Form;

use Zend\Form\Form;

use Category\Mapper\CategoryMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class CategoryForm extends Form
{
    /**
     * @var \Category\Mapper\CategoryMapperInterface
     */
    protected $categoryMapper;
    
    /**
     * @param string $name
     * @param array  $options
     */
    public function __construct($name, array $options = array())
    {
        parent::__construct($name, $options);
        
        // Add form elements
        $this
            ->addSlug()
            ->addName()
            ->addPriority()
        ;
    }
    
    /**
     * Add the name element.
     * 
     * @return \Category\Form\CategoryForm
     */
    protected function addName()
    {
        // Media name
        $this->add(array(
            'name'    => 'name',
            'type'    => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Name',
            ),
            'attributes' => array(
                'class'       => 'form-control',
                'placeholder' => 'Name',
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add the slug element.
     * 
     * @return \Category\Form\CategoryForm
     */
    protected function addSlug()
    {
        // Media name
        $this->add(array(
            'name'    => 'slug',
            'type'    => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Slug',
            ),
            'attributes' => array(
                'class'       => 'form-control',
                'placeholder' => 'Slug',
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add the priority element.
     * 
     * @return \Category\Form\CategoryForm
     */
    protected function addPriority()
    {
        // Media name
        $this->add(array(
            'name'    => 'priority',
            'type'    => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Priority',
            ),
            'attributes' => array(
                'class'       => 'form-control',
                'placeholder' => 'Priority',
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add the submit element.
     * 
     * @return \Category\Form\CategoryForm
     */
    protected function addSubmit()
    {
        $this->add(array(
            'name'    => 'submit',
            'type'    => 'Zend\Form\Element\submit',
            'options' => array(
                'label' => 'Save',
            ),
            'attributes' => array(
                'class' => 'btn btn-primary',
            ),
        ));
        
        return $this;
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