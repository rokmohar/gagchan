<?php

namespace Media\Form;

use Zend\Form\Form;

use Media\Mapper\CategoryMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class MediaForm extends Form
{
    /**
     * @var \Media\Mapper\CategoryMapperInterface
     */
    protected $categoryMapper;
    
    /**
     * @param String                                $name
     * @param \Media\Mapper\CategoryMapperInterface $categoryMapper
     */
    public function __construct($name, CategoryMapperInterface $categoryMapper)
    {
        parent::__construct($name);
        
        // Set category mapper
        $this->categoryMapper = $categoryMapper;
        
        // Set form attributes
        $this
            ->setAttribute('enctype', 'multipart/form-data')
        ;
        
        // Add form elements
        $this
            ->addName()
            ->addFile()
            ->addUrl()
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
     * Add media file input field.
     * 
     * @return \Media\Form\MediaForm
     */
    protected function addFile()
    {
        $this->add(array(
            'name'    => 'file',
            'options' => array(
                'label' => 'Upload',
            ),
            'attributes' => array(
                'type'        => 'file',
                'class'       => 'form-control',
                'placeholder' => 'Upload',
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add media URL input field.
     * 
     * @return \Media\Form\MediaForm
     */
    protected function addUrl()
    {
        $this->add(array(
            'name'    => 'url',
            'options' => array(
                'label' => 'URL',
            ),
            'attributes' => array(
                'type'        => 'text',
                'class'       => 'form-control',
                'placeholder' => 'URL',
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add category dropdown.
     * 
     * @param Array $values
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