<?php

namespace Media\InputFilter;

use Core\InputFilter\AbstractFilter;
use Media\Mapper\MediaMapperInterface;
use User\Mapper\UserMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class VoteFilter extends AbstractFilter
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
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        parent::__construct($options);
        
        // Add input filters
        $this
            ->addSlug()
            ->addType()
        ;
    }
    
    /**
     * Add slug input filter.
     * 
     * @return \Media\InputFilter\MediaFilter
     */
    public function addSlug()
    {
        $this->add(array(
            'name'     => 'slug',
            'required' => true,
        ));
        
        return $this;
    }
    
    /**
     * Add type input filter.
     * 
     * @return \Media\InputFilter\MediaFilter
     */
    public function addType()
    {
        $this->add(array(
            'name'       => 'type',
            'required'   => true,
            'validators' => array(
                array(
                    'name'    => 'Inarray',
                    'options' => array(
                        'haystack' => array('up', 'down'),
                    ),
                ),
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