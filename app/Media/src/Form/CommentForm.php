<?php

namespace Media\Form;

use Zend\Form\Form;

use Media\Mapper\CommentMapperInterface;
use Media\Mapper\MediaMapperInterface;
use User\Mapper\UserMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class CommentForm extends Form
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
     * @param string $name
     * @param array  $options
     */
    public function __construct($name, array $options = array())
    {
        parent::__construct($name, $options);
        
        // Add elements
        $this
            ->addComment()
            ->addSubmit()
        ;
    }
    
    /**
     * Add the comment element.
     * 
     * @return \Media\Form\MediaForm
     */
    protected function addComment()
    {
        $this->add(array(
            'name'    => 'comment',
            'type'    => 'Zend\Form\Element\Textarea',
            'options' => array(
                'label' => 'Your comment',
            ),
            'attributes' => array(
                'class'       => 'form-control',
                'style'       => 'resize: vertical;',
                'placeholder' => 'Your comment',
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
            'type'    => 'Zend\Form\Element\Submit',
            'options' => array(
                'label' => 'Submit',
            ),
            'attributes' => array(
                'class' => 'btn btn-primary',
            ),
        ));
        
        return $this;
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