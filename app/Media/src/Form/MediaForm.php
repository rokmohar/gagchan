<?php

namespace Media\Form;

use Zend\Form\Form;

use Media\Mapper\MediaMapperInterface;
use Category\Mapper\CategoryMapperInterface;
use User\Mapper\UserMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class MediaForm extends Form
{
    /**
     * @var \Media\Mapper\MediaMapperInterface
     */
    protected $mediaMapper;
    
    /**
     * @var \User\Mapper\UserMapperInterface
     */
    protected $userMapper;
    
    /**
     * @var \Media\Mapper\CategoryMapperInterface
     */
    protected $categoryMapper;
    
    /**
     * @param string $name
     * @param array  $options
     */
    public function __construct($name, $options)
    {
        parent::__construct($name, $options);
        
        // Add elements
        $this
            ->addCsrf()
            ->addSlug()
            ->addName()
            ->addReference()
            ->addThumbnail()
            ->addUserId()
            ->addCategoryId()
            ->addHeight()
            ->addWidth()
            ->addSize()
            ->addContentType()
            ->addIsFeatured()
            ->addState()
            ->addDelayAt()
            ->addSubmit()
        ;
    }
    
    /**
     * Add the CSRF element.
     * 
     * @return \Media\Form\MediaForm
     */
    protected function addCsrf()
    {
        // Media name
        $this->add(array(
            'name' => 'csrf',
            'type' => 'Zend\Form\Element\Csrf',
        ));
        
        return $this;
    }
    
    /**
     * Add the slug element.
     * 
     * @return \Media\Form\MediaForm
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
     * Add the reference element.
     * 
     * @return \Media\Form\MediaForm
     */
    protected function addReference()
    {
        // Media name
        $this->add(array(
            'name'    => 'reference',
            'type'    => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Reference',
            ),
            'attributes' => array(
                'class'       => 'form-control',
                'placeholder' => 'Reference',
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add the thumbnail element.
     * 
     * @return \Media\Form\MediaForm
     */
    protected function addThumbnail()
    {
        // Media name
        $this->add(array(
            'name'    => 'thumbnail',
            'type'    => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Thumbnail',
            ),
            'attributes' => array(
                'class'       => 'form-control',
                'placeholder' => 'Thumbnail',
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add the user identifier element.
     * 
     * @param array $values
     * 
     * @return \Media\Form\MediaForm
     */
    protected function addUserId(array $values = array())
    {
        $this->add(array(
            'name'    => 'user_id',
            'type'    => 'Zend\Form\Element\Select',
            'options' => array(
                'value_options' => $values,
                'empty_option'  => 'Choose user ...',
            ),
            'attributes' => array(
                'class' => 'form-control',
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
        // Get category mapper
        $categoryMapper = $this->getCategoryMapper();
        
        // Check if category mapper is empty
        if (empty($categoryMapper)) {
            // Throw an exception
            throw new \RuntimeException("Category mapper is required, none given.");
        }
        
        // Iterate over values
        foreach ($categoryMapper->selectAll() as $category) {
            // Add value
            $values[$category->getId()] = $category->getName();
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
     * Add the height element.
     * 
     * @return \Media\Form\MediaForm
     */
    protected function addHeight()
    {
        // Media name
        $this->add(array(
            'name'    => 'height',
            'type'    => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Height',
            ),
            'attributes' => array(
                'class'       => 'form-control',
                'placeholder' => 'Height',
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add the width element.
     * 
     * @return \Media\Form\MediaForm
     */
    protected function addWidth()
    {
        // Media name
        $this->add(array(
            'name'    => 'width',
            'type'    => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Width',
            ),
            'attributes' => array(
                'class'       => 'form-control',
                'placeholder' => 'Width',
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add the size element.
     * 
     * @return \Media\Form\MediaForm
     */
    protected function addSize()
    {
        // Media name
        $this->add(array(
            'name'    => 'size',
            'type'    => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Size',
            ),
            'attributes' => array(
                'class'       => 'form-control',
                'placeholder' => 'Size',
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add the content type element.
     * 
     * @return \Media\Form\MediaForm
     */
    protected function addContentType()
    {
        // Media name
        $this->add(array(
            'name'    => 'content_type',
            'type'    => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Content Type',
            ),
            'attributes' => array(
                'class'       => 'form-control',
                'placeholder' => 'Content Type',
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add the is featured type element.
     * 
     * @return \Media\Form\MediaForm
     */
    protected function addIsFeatured()
    {
        // Media name
        $this->add(array(
            'name'    => 'is_featured',
            'type'    => 'Zend\Form\Element\Checkbox',
            'options' => array(
                'label' => 'Is Featured',
            ),
            'attributes' => array(
                'class'       => 'form-control',
                'placeholder' => 'Is Featured',
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add the state type element.
     * 
     * @return \Media\Form\MediaForm
     */
    protected function addState()
    {
        // Media name
        $this->add(array(
            'name'    => 'state',
            'type'    => 'Zend\Form\Element\Checkbox',
            'options' => array(
                'label' => 'State',
            ),
            'attributes' => array(
                'class'       => 'form-control',
                'placeholder' => 'State',
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
    
    /**
     * Return the media mapper.
     * 
     * @return \Media\Mapper\MediaMapperInterface
     */
    protected function getMediaMapper()
    {
        // Check if media mapper is empty
        if ($this->mediaMapper === null) {
            // Set media mapper
            $this->setMediaMapper($this->getOption('media_mapper'));
        }
        
        return $this->mediaMapper;
    }
    
    /**
     * Set the media mapper.
     * 
     * @param \Media\Mapper\MediaMapperInterface $mediaMapper
     */
    protected function setMediaMapper(MediaMapperInterface $mediaMapper)
    {
        $this->mediaMapper = $mediaMapper;
        
        return $this;
    }
    
    /**
     * Return the user mapper.
     * 
     * @return \User\Mapper\UserMapperInterface
     */
    protected function getUserMapper()
    {
        // Check if user mapper is empty
        if ($this->userMapper === null) {
            // Set user mapper
            $this->setUserMapper($this->getOption('user_mapper'));
        }
        
        return $this->userMapper;
    }
    
    /**
     * Set the user mapper.
     * 
     * @param \User\Mapper\UserMapperInterface $userMapper
     */
    protected function setUserMapper(UserMapperInterface $userMapper)
    {
        $this->userMapper = $userMapper;
        
        return $this;
    }
    
    /**
     * Return the category mapper.
     * 
     * @return \Category\Mapper\CategoryMapperInterface
     */
    protected function getCategoryMapper()
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
    protected function setCategoryMapper(CategoryMapperInterface $categoryMapper)
    {
        $this->categoryMapper = $categoryMapper;
        
        return $this;
    }
}