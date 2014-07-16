<?php

namespace Media\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class ModuleOptions extends AbstractOptions
{
    /**
     * @var Boolean
     */
    protected $__strictMode__ = false;
    
    /**
     * @var String
     */
    protected $commentEntity = 'Media\Entity\CommentEntity';
    
    /**
     * @var String
     */
    protected $commentHydrator = 'Media\Hydrator\CommentHydrator';
    
    /**
     * @var String
     */
    protected $commentMapper = 'Media\Mapper\CommentMapper';
    
    /**
     * @var String
     */
    protected $mediaEntity = 'Media\Entity\MediaEntity';
    
    /**
     * @var String
     */
    protected $mediaHydrator = 'Media\Hydrator\MediaHydrator';
    
    /**
     * @var String
     */
    protected $mediaMapper = 'Media\Mapper\MediaMapper';
    
    /**
     * @var String
     */
    protected $voteEntity = 'Media\Entity\VoteEntity';
    
    /**
     * @var String
     */
    protected $voteHydrator = 'Media\Hydrator\VoteHydrator';
    
    /**
     * @var String
     */
    protected $voteMapper = 'Media\Mapper\VoteMapper';
    
    /**
     * @return String
     */
    public function getCommentEntity()
    {
        return $this->commentEntity;
    }
    
    /**
     * @var String
     */
    public function getCommentHydrator()
    {
        return $this->commentHydrator;
    }
    
    /**
     * @return String
     */
    public function getCommentMapper()
    {
        return $this->commentMapper;
    }
    
    /**
     * @return String
     */
    public function getMediaEntity()
    {
        return $this->mediaEntity;
    }
    
    /**
     * @return String
     */
    public function getMediaHydrator()
    {
        return $this->mediaHydrator;
    }
    
    /**
     * @return String
     */
    public function getMediaMapper()
    {
        return $this->mediaMapper;
    }
    
    /**
     * @return String
     */
    public function getVoteEntity()
    {
        return $this->voteEntity;
    }
    
    /**
     * @return String
     */
    public function getVoteHydrator()
    {
        return $this->voteHydrator;
    }
    
    /**
     * @return String
     */
    public function getVoteMapper()
    {
        return $this->voteMapper;
    }
}