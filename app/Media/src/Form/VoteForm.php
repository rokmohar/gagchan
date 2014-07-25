<?php

namespace Media\Form;

use Zend\Form\Form;

use Media\Mapper\MediaMapperInterface;
use User\Mapper\UserMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class VoteForm extends Form
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
     * @param string $name
     * @param array  $options
     */
    public function __construct($name, array $options = array())
    {
        parent::__construct($name, $options);
        
        // Add form elements
        $this
            ->addSlug()
            ->addType()
        ;
    }
    
    /**
     * Add the slug element.
     * 
     * @return \Media\Form\MediaForm
     */
    protected function addSlug()
    {
        $this->add(array(
            'name'    => 'slug',
            'type'    => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Slug',
            ),
        ));
        
        return $this;
    }
    /**
     * Add the type element.
     * 
     * @return \Media\Form\MediaForm
     */
    protected function addType()
    {
        $this->add(array(
            'name'    => 'type',
            'type'    => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Type',
            ),
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
    public function setUserMapper(UserMapperInterface $userMapper)
    {
        $this->userMapper = $userMapper;
        
        return $this;
    }
}