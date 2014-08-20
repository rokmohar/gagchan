<?php

namespace Media\InputFilter;

use Zend\InputFilter\InputFilter;

use Category\Mapper\CategoryMapperInterface;
use Media\Mapper\MediaMapperInterface;
use User\Mapper\UserMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class MediaFilter extends InputFilter
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
     * @var \Category\Mapper\CategoryMapperInterface
     */
    protected $categoryMapper;
    
    /**
     * @param \Media\Mapper\MediaMapperInterface    $mediaMapper
     * @param \User\Mapper\UserMapperInterface      $userMapper
     * @param \Media\Mapper\CategoryMapperInterface $categoryMapper
     */
    public function __construct(
        MediaMapperInterface $mediaMapper,
        UserMapperInterface $userMapper,
        CategoryMapperInterface $categoryMapper
            
    ) {
        // Set media mapper
        $this->setMediaMapper($mediaMapper);
        
        // Set user mapper
        $this->setUserMapper($userMapper);
        
        // Set category mapper
        $this->setCategoryMapper($categoryMapper);
        
        // Add filters
        $this
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
        ;
    }
    
    /**
     * Add filter for the name element.
     * 
     * @return \Media\InputFilter\MediaFilter
     */
    protected function addName()
    {
        $this->add(array(
            'name'       => 'name',
            'required'   => true,
            'validators' => array(
                array(
                    'name'    => 'Zend\Validator\StringLength',
                    'options' => array(
                        'min' => 4,
                        'max' => 128,
                    ),
                ),
            ),
            'filters' => array(
                array('name' => 'Zend\Filter\HtmlEntities'),
                array('name' => 'Zend\Filter\StringTrim'),
                array('name' => 'Zend\Filter\StripTags'),
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add filter for the slug element.
     * 
     * @return \Media\InputFilter\MediaFilter
     */
    protected function addSlug()
    {
        $this->add(array(
            'name'       => 'slug',
            'required'   => true,
            'validators' => array(
                array(
                    'name'    => 'Zend\Validator\StringLength',
                    'options' => array(
                        'min' => 4,
                        'max' => 32,
                    ),
                ),
            ),
            'filters' => array(
                array('name' => 'Zend\Filter\HtmlEntities'),
                array('name' => 'Zend\Filter\StringTrim'),
                array('name' => 'Zend\Filter\StripTags'),
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add filter for the reference element.
     * 
     * @return \Media\InputFilter\MediaFilter
     */
    protected function addReference()
    {
        $this->add(array(
            'name'      => 'reference',
            'required' => true,
            'filters'  => array(
                array('name' => 'Zend\Filter\HtmlEntities'),
                array('name' => 'Zend\Filter\StringTrim'),
                array('name' => 'Zend\Filter\StripTags'),
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add filter for the thumbnail element.
     * 
     * @return \Media\InputFilter\MediaFilter
     */
    protected function addThumbnail()
    {
        $this->add(array(
            'name'     => 'thumbnail',
            'required' => true,
            'filters'  => array(
                array('name' => 'Zend\Filter\HtmlEntities'),
                array('name' => 'Zend\Filter\StringTrim'),
                array('name' => 'Zend\Filter\StripTags'),
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add filter for the user element.
     * 
     * @return \Media\InputFilter\MediaFilter
     */
    protected function addUserId()
    {
        $this->add(array(
            'name'     => 'user_id',
            'required' => true,
        ));
        
        return $this;
    }
    
    /**
     * Add filter for the category element.
     * 
     * @return \Media\InputFilter\MediaFilter
     */
    protected function addCategoryId()
    {
        $this->add(array(
            'name'     => 'category_id',
            'required' => true,
        ));
        
        return $this;
    }
    
    /**
     * Add filter for the height element.
     * 
     * @return \Media\InputFilter\MediaFilter
     */
    protected function addHeight()
    {
        $this->add(array(
            'name'     => 'height',
            'required' => true,
            'filters'  => array(
                array('name' => 'Zend\Filter\Int'),
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add filter for the width element.
     * 
     * @return \Media\InputFilter\MediaFilter
     */
    protected function addWidth()
    {
        $this->add(array(
            'name'     => 'width',
            'required' => true,
            'filters'  => array(
                array('name' => 'Zend\Filter\Int'),
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add filter for the size element.
     * 
     * @return \Media\InputFilter\MediaFilter
     */
    protected function addSize()
    {
        $this->add(array(
            'name'     => 'size',
            'required' => true,
            'filters'  => array(
                array('name' => 'Zend\Filter\Int'),
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add filter for the content type element.
     * 
     * @return \Media\InputFilter\MediaFilter
     */
    protected function addContentType()
    {
        $this->add(array(
            'name'     => 'content_type',
            'required' => true,
            'filters'  => array(
                array('name' => 'Zend\Filter\HtmlEntities'),
                array('name' => 'Zend\Filter\StringTrim'),
                array('name' => 'Zend\Filter\StripTags'),
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add filter for the is featured element.
     * 
     * @return \Media\InputFilter\MediaFilter
     */
    protected function addIsFeatured()
    {
        $this->add(array(
            'name'     => 'is_featured',
            'required' => true,
            'filters'  => array(
                array('name' => 'Zend\Filter\Boolean'),
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add filter for the state element.
     * 
     * @return \Media\InputFilter\MediaFilter
     */
    protected function addState()
    {
        $this->add(array(
            'name'     => 'is_featured',
            'required' => true,
            'filters'  => array(
                array('name' => 'Zend\Filter\Int'),
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add filter for the delay at form element.
     * 
     * @return \Media\InputFilter\MediaFilter
     */
    public function addDelayAt()
    {
        $this->add(array(
            'name'     => 'delay_at',
            'required' => false, // for admins
        ));
        
        return $this;
    }
    
    /**
     * Return the media mapper.
     * 
     * @return \Media\Mapper\MediaMapperInterface
     */
    public function getMediaMapper()
    {
        return $this->mediaMapper;
    }
    
    /**
     * Set the media mapper.
     * 
     * @param \Media\Mapper\MediaMapperInterface $mediaMapper
     */
    public function setMediaMapper(MediaMapperInterface $mediaMapper)
    {
        $this->mediaMapper = $mediaMapper;
        
        return $this;
    }
    
    /**
     * Return the user mapper.
     * 
     * @return \User\Mapper\UserMapperInterface
     */
    public function getUserMapper()
    {
        return $this->userMapper;
    }
    
    /**
     * Set the user mapper.
     * 
     * @param \User\Mapper\UserMapperInterface $userMapper
     */
    public function setUserMapper(UserMapperInterface $userMapper)
    {
        $this->userMapper = $userMapper;
        
        return $this;
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