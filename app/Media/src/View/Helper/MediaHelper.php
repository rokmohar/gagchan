<?php

namespace Media\View\Helper;

use Zend\Authentication\AuthenticationService;
use Zend\View\Helper\AbstractHelper;

use Media\Entity\MediaEntityInterface;
use Media\Entity\VoteEntityInterface;
use Media\Mapper\CommentMapperInterface;
use Media\Mapper\MediaMapperInterface;
use Media\Mapper\VoteMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class MediaHelper extends AbstractHelper
{
    /**
     * @var \Zend\Authentication\AuthenticationService
     */
    protected $authService;
    
    /**
     * @var String
     */
    protected $bucketUrl = 'http://cdn.gagchan.com';
    
    /**
     * @var \Media\Mapper\CommentMapperInterface
     */
    protected $commentMapper;
    
    /**
     * @var \Media\Mapper\MediaMapperInterface
     */
    protected $mediaMapper;
    
    /**
     * @var \Media\Mapper\VoteMapperInterface
     */
    protected $voteMapper;
    
    /**
     * @param \Media\Mapper\MediaMapperInterface         $mediaMapper
     * @param \Media\Mapper\CommentMapperInterface       $commentMapper
     * @param \Media\Mapper\VoteMapperInterface          $voteMapper
     * @param \Zend\Authentication\AuthenticationService $authService
     */
    public function __construct(
        MediaMapperInterface $mediaMapper,
        CommentMapperInterface $commentMapper,
        VoteMapperInterface $voteMapper,
        AuthenticationService $authService
    ) {
        $this->mediaMapper   = $mediaMapper;
        $this->commentMapper = $commentMapper;
        $this->voteMapper    = $voteMapper;
        $this->authService   = $authService;
    }
    
    /**
     * __invoke
     *
     * @return \ZfcUser\Entity\UserInterface
     */
    public function __invoke()
    {
        return $this;
    }
    
    /**
     * Get vote entity for media.
     * 
     * @param \Media\Entity\MediaEntityInterface $media
     * 
     * @return mixed
     */
    public function getVote(MediaEntityInterface $media)
    {
        // Get user
        $user = $this->authService->getIdentity();
        
        // Return vote
        return ($user !== null) ? $this->voteMapper->selectRowByMedia($media->getId(), $user->getId()) : null;
    }
    
    /**
     * Check if vote type is down.
     * 
     * @param \Media\Entity\VoteEntityInterface $vote
     * 
     * @return Boolean
     */
    public function isVoteDown(VoteEntityInterface $vote)
    {
        return ($vote->getType() === 'down');
    }
    
    /**
     * Check if vote type is up.
     * 
     * @param \Media\Entity\VoteEntityInterface $vote
     * 
     * @return Boolean
     */
    public function isVoteUp(VoteEntityInterface $vote)
    {
        return ($vote->getType() === 'up');
    }
    
    /**
     * Generate URL for media.
     * 
     * @param \Media\Entity\MediaEntityInterface $media
     * 
     * @return String
     */
    public function url(MediaEntityInterface $media)
    {
        return $this->bucketUrl . $media->getReference();
    }
    
    /**
     * Return points for media.
     * 
     * @param \Media\Entity\MediaEntityInterface $media
     * 
     * @return Integer
     */    
    public function getPoints(MediaEntityInterface $media)
    {
       return $this->voteMapper->countByMedia($media->getId()); 
    }
    
    /**
     * Return number of comments for media.
     * 
     * @param \Media\Entity\MediaEntityInterface $media
     * 
     * @return Integer
     */    
    public function getComments(MediaEntityInterface $media)
    {
       return $this->commentMapper->countByMedia($media->getId()); 
    }
}
