<?php

namespace Media\Form;

use Zend\Form\Form;

use Media\Mapper\MediaMapperInterface;
use Media\Mapper\VoteMapperInterface;
use User\Mapper\UserMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class VoteForm extends Form
{
    /**
     * @var \Media\Mapper\VoteMapperInterface
     */
    protected $voteMapper;
    
    /**
     * @var \Media\Mapper\MediaMapperInterface
     */
    protected $mediaMapper;
    
    /**
     * @var \User\Mapper\UserMapperInterface
     */
    protected $userMapper;
    
    /**
     * @param \Media\Mapper\VoteMapperInterface  $voteMapper
     * @param \Media\Mapper\MediaMapperInterface $mediaMapper
     * @param \User\Mapper\UserMapperInterface   $userMapper
     */
    public function __construct(
        VoteMapperInterface $voteMapper,
        MediaMapperInterface $mediaMapper,
        UserMapperInterface $userMapper
    ) {
        parent::__construct();
        
        // Set vote mapper
        $this->setVoteMapper($voteMapper);
        
        // Set media mapper
        $this->setMediaMapper($mediaMapper);
        
        // Set user mapper
        $this->setUserMapper($userMapper);
        
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
     * Return the vote mapper.
     * 
     * @return \Media\Mapper\VoteMapperInterface
     */
    public function getVoteMapper()
    {
        return $this->voteMapper;
    }
    
    /**
     * Set the vote mapper.
     * 
     * @param \Media\Mapper\VoteMapperInterface $voteMapper
     */
    public function setVoteMapper(VoteMapperInterface $voteMapper)
    {
        $this->voteMapper = $voteMapper;
        
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