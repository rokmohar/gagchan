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
            ->addCategoryId()
            ->addSubmit()
        ;
    }
    
    /**
     * Add the name element.
     * 
     * @return \Media\Form\MediaForm
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
     * Add the category identifier element.
     * 
     * @param array $values
     * 
     * @return \Media\Form\MediaForm
     */
    protected function addCategoryId(array $values = array())
    {
        $result = $this->categoryMapper->selectAll();
        
        // Add element values
        foreach ($result as $r) {
            // Add value for key
            $values[$r->getId()] = $r->getName();
        }
        
        $this->add(array(
            'name'    => 'category_id',
            'type'    => 'Zend\Form\Element\Select',
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
     * Add the delay at element.
     * 
     * @return \Media\Form\MediaForm
     */
    public function addDelayAt()
    {
        $this->add(array(
            'name'    => 'delay_at',
            'type'    => 'Zend\Form\Element\DateTime',
            'options' => array(
                'label'  => 'Delay at',
                'format' => 'Y-m-d H:i:s'
            ),
            'attributes' => array(
                'class'       => 'form-control',
                'placeholder' => 'Delay at',
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add the submit element.
     * 
     * @return \Media\Form\MediaForm
     */
    protected function addSubmit()
    {
        $this->add(array(
            'name'    => 'submit',
            'type'    => 'Zend\Form\Element\submit',
            'options' => array(
                'label' => 'Upload',
            ),
            'attributes' => array(
                'class' => 'btn btn-primary',
            ),
        ));
        
        return $this;
    }
}