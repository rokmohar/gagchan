<?php

namespace Generator\Form;

use Category\Mapper\CategoryMapperInterface;
use Media\Form\MediaForm;
use Media\Mapper\MediaMapperInterface;
use User\Mapper\UserMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class PublishForm extends MediaForm
{
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
        parent::__construct($mediaMapper, $userMapper, $categoryMapper);
        
        // Add elements
        $this
            ->addToken()
        ;
    }
    
    /**
     * Add the token element.
     * 
     * @return \Generator\Form\PublishForm
     */
    public function addToken()
    {
        $this->add(array(
            'name' => 'token',
            'type' => 'Zend\Form\Element\Hidden',
        ));
        
        return $this;
    }
    
    /**
     * Set the token value.
     * 
     * @param string $value
     */
    public function setTokenValue($value)
    {
        // Check if token element exists
        if ($this->has('token')) {
            // Set token value
            $this->get('token')->setValue($value);
        }
        
        
        return $this;
    }
}