<?php

namespace Media\InputFilter;

use Zend\InputFilter\InputFilter;

use Media\Mapper\CommentMapperInterface;
use Media\Mapper\MediaMapperInterface;
use User\Mapper\UserMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class CommentFilter extends InputFilter
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
     * @param \Media\Mapper\CommentMapperInterface $commentMapper
     * @param \Media\Mapper\MediaMapperInterface   $mediaMapper
     * @param \User\Mapper\UserMapperInterface     $userMapper
     */
    public function __construct(
        CommentMapperInterface $commentMapper,
        MediaMapperInterface $mediaMapper,
        UserMapperInterface $userMapper
    ) {
        // Set comment mapper
        $this->setCommentMapper($commentMapper);
        
        // Set media mapper
        $this->setMediaMapper($mediaMapper);
        
        // Set user mapper
        $this->setUserMapper($userMapper);
        
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
}