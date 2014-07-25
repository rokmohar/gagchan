<?php

namespace Media\InputFilter;

use Core\InputFilter\AbstractFilter;
use Media\Mapper\CommentMapperInterface;
use Media\Mapper\MediaMapperInterface;
use User\Mapper\UserMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class CommentFilter extends AbstractFilter
{
    /**
     * @var \Media\Mapper\CommentMapperInterface
     */
    protected $commentMapper;
    
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
        
        // Add form elements
        $this
            ->addComment()
        ;
    }
    
    /**
     * Add filter for comment.
     */
    protected function addComment()
    {
        $this->add(array(
            'name'       => 'comment',
            'required'   => true,
            'validators' => array(
                array(
                    'name'    => 'stringLength',
                    'options' => array(
                        'min' => 8,
                        'max' => 255,
                    ),
                ),
            ),
            'filters'   => array(
                array('name' => 'HtmlEntities'),
                array('name' => 'stringTrim'),
                array('name' => 'StripTags'),
            ),
        ));
    }
    
    /**
     * Return the comment mapper.
     * 
     * @return \Media\Mapper\CommentMapperInterface
     */
    public function getCommentMapper()
    {
        // Check if comment mapper is empty
        if ($this->commentMapper === null) {
            // Set comment mapper
            $this->setCommentMapper($this->getOption('comment_mapper'));
        }
        
        return $this->commentMapper;
    }
    
    /**
     * Set the comment mapper.
     * 
     * @param \Media\Mapper\CommentMapperInterface $commentMapper
     */
    public function setCommentMapper(CommentMapperInterface $commentMapper)
    {
        $this->commentMapper = $commentMapper;
        
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