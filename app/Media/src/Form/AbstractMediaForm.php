<?php

namespace Media\Form;

use Zend\Form\Form;

use Category\Mapper\CategoryMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
abstract class AbstractMediaForm extends Form
{
    /**
     * @var \Media\Mapper\CategoryMapperInterface
     */
    protected $categoryMapper;
    
    /**
     * @param string                                $name
     * @param \Media\Mapper\CategoryMapperInterface $categoryMapper
     */
    public function __construct($name, CategoryMapperInterface $categoryMapper)
    {
        parent::__construct($name);
        
        // Set category mapper
        $this->categoryMapper = $categoryMapper;
        
        // Add form elements
        $this
            ->addName()
            ->addCategory()
            ->addSubmit()
        ;
    }
    
    /**
     * Add media name input field.
     * 
     * @return \Media\Form\MediaForm
     */
    protected function addName()
    {
        // Media name
        $this->add(array(
            'name'    => 'name',
            'options' => array(
                'label' => 'Name',
            ),
            'attributes' => array(
                'type'        => 'text',
                'class'       => 'form-control',
                'placeholder' => 'Name',
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add category dropdown.
     * 
     * @param array $values
     * 
     * @return \Media\Form\MediaForm
     */
    protected function addCategory(array $values = array())
    {
        $result = $this->categoryMapper->selectAll();
        
        foreach ($result as $category) {
            $values[$category->getId()] = $category->getName();
        }
        
        $this->add(array(
            'type'    => 'select',
            'name'    => 'category',
            'options' => array(
                'value_options' => $values,
                'empty_option'  => 'Choose category ...',
            ),
            'attributes' => array(
                'class' => 'form-control',
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add submit button.
     * 
     * @return \Media\Form\MediaForm
     */
    protected function addSubmit()
    {
        $this->add(array(
            'name'    => 'submit',
            'options' => array(
                'label' => 'Upload',
            ),
            'attributes' => array(
                'type'  => 'submit',
                'class' => 'btn btn-primary',
            ),
        ));
        
        return $this;
    }
}