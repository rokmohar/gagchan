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
    protected $bucket = 'gagchan';
    
    /**
     * @var String
     */
    protected $bucketUrl = 'http://cdn.gagchan.com';
    
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
    public function getBucket()
    {
        return $this->bucket;
    }
    
    /**
     * @param string $bucket
     */
    public function setBucket($bucket)
    {
        $this->bucket = $bucket;
        
        return $this;
    }
    
    /**
     * @return String
     */
    public function getBucketUrl()
    {
        return $this->bucketUrl;
    }
    
    /**
     * @param string $bucketUrl
     */
    public function setBucketUrl($bucketUrl)
    {
        $this->bucketUrl = $bucketUrl;
        
        return $this;
    }
    
    /**
     * @return String
     */
    public function getCommentEntity()
    {
        return $this->commentEntity;
    }
    
    /**
     * @param string $commentEntity
     */
    public function setCommentEntity($commentEntity)
    {
        $this->commentEntity = $commentEntity;
        
        return $this;
    }
    
    /**
     * @var String
     */
    public function getCommentHydrator()
    {
        return $this->commentHydrator;
    }
    
    /**
     * @param string $commentHydrator
     */
    public function setCommentHydrator($commentHydrator)
    {
        $this->commentHydrator = $commentHydrator;
        
        return $this;
    }
    
    /**
     * @return String
     */
    public function getCommentMapper()
    {
        return $this->commentMapper;
    }
    
    /**
     * @param string $commentMapper
     */
    public function setCommentMapper($commentMapper)
    {
        $this->commentMapper = $commentMapper;
        
        return $this;
    }
    
    /**
     * @return String
     */
    public function getMediaEntity()
    {
        return $this->mediaEntity;
    }
    
    /**
     * @param string $mediaEntity
     */
    public function setMediaEntity($mediaEntity)
    {
        $this->mediaEntity = $mediaEntity;
        
        return $this;
    }
    
    /**
     * @return String
     */
    public function getMediaHydrator()
    {
        return $this->mediaHydrator;
    }
    
    /**
     * @param string $mediaHydrator
     */
    public function setMediaHydrator($mediaHydrator)
    {
        $this->mediaHydrator = $mediaHydrator;
        
        return $this;
    }
    
    /**
     * @return String
     */
    public function getMediaMapper()
    {
        return $this->mediaMapper;
    }
    
    /**
     * @param string $mediaMapper
     */
    public function setMediaMapper($mediaMapper)
    {
        $this->mediaMapper = $mediaMapper;
        
        return $this;
    }
    
    /**
     * @return String
     */
    public function getVoteEntity()
    {
        return $this->voteEntity;
    }
    
    /**
     * @param string $voteEntity
     */
    public function setVoteEntity($voteEntity)
    {
        $this->voteEntity = $voteEntity;
        
        return $this;
    }
    
    /**
     * @return String
     */
    public function getVoteHydrator()
    {
        return $this->voteHydrator;
    }
    
    /**
     * @param string $voteHydrator
     */
    public function setVoteHydrator($voteHydrator)
    {
        $this->voteHydrator = $voteHydrator;
        
        return $this;
    }
    
    /**
     * @return String
     */
    public function getVoteMapper()
    {
        return $this->voteMapper;
    }
    
    /**
     * @param string $voteMapper
     */
    public function setVoteMapper($voteMapper)
    {
        $this->voteMapper = $voteMapper;
        
        return $this;
    }
}