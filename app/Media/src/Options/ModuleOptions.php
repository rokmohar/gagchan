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
     * @var bool
     */
    protected $__strictMode__ = false;
    
    /**
     * @var string
     */
    protected $bucket = 'gagchan';
    
    /**
     * @var string
     */
    protected $bucketUrl = 'http://cdn.gagchan.com';
    
    /**
     * @var string
     */
    protected $commentEntity = 'Media\Entity\CommentEntity';
    
    /**
     * @var string
     */
    protected $commentHydrator = 'Media\Hydrator\CommentHydrator';
    
    /**
     * @var string
     */
    protected $commentMapper = 'Media\Mapper\CommentMapper';
    
    /**
     * @var string
     */
    protected $mediaEntity = 'Media\Entity\MediaEntity';
    
    /**
     * @var string
     */
    protected $mediaHydrator = 'Media\Hydrator\MediaHydrator';
    
    /**
     * @var string
     */
    protected $mediaMapper = 'Media\Mapper\MediaMapper';
    
    /**
     * @var string
     */
    protected $voteEntity = 'Media\Entity\VoteEntity';
    
    /**
     * @var string
     */
    protected $voteHydrator = 'Media\Hydrator\VoteHydrator';
    
    /**
     * @var string
     */
    protected $voteMapper = 'Media\Mapper\VoteMapper';
    
    /**
     * @return string
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
     * @return string
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
     * @return string
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
     * @var string
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
     * @return string
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
     * @return string
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
     * @return string
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
     * @return string
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
     * @return string
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
     * @return string
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
     * @return string
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