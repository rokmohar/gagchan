<?php

namespace Media\View\Helper;

use Zend\View\Helper\AbstractHelper;

use Media\Entity\MediaEntityInterface;
use Media\Entity\VoteEntityInterface;
use Media\Mapper\CommentMapperInterface;
use Media\Mapper\MediaMapperInterface;
use Media\Mapper\VoteMapperInterface;
use Media\Options\ModuleOptions;
use User\Authentication\AuthenticationService;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class MediaHelper extends AbstractHelper
{
    /**
     * @var \User\Authentication\AuthenticationService
     */
    protected $authService;
    
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
     * @var \Media\Options\ModuleOptions
     */
    protected $options;
    
    /**
     * @param \User\Authentication\AuthenticationService $authService
     * @param \Media\Mapper\CommentMapperInterface       $commentMapper
     * @param \Media\Mapper\MediaMapperInterface         $mediaMapper
     * @param \Media\Mapper\VoteMapperInterface          $voteMapper
     * @param \Media\Options\ModuleOptions               $options
     */
    public function __construct(
        AuthenticationService $authService,
        CommentMapperInterface $commentMapper,
        MediaMapperInterface $mediaMapper,
        VoteMapperInterface $voteMapper,
        ModuleOptions $options
    ) {
        $this->authService   = $authService;
        $this->commentMapper = $commentMapper;
        $this->mediaMapper   = $mediaMapper;
        $this->voteMapper    = $voteMapper;
        $this->options       = $options;
    }
    
    /**
     * {@inheritDoc}
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
        
        // Check if user is not empty
        if (!empty($user)) {
            // Select row from database
            $result = $this->voteMapper->selectRowByMedia($media, $user);
            
            // Return result
            return !empty($result) ? $result : null;
        }
        
        return null;
    }
    
    /**
     * Check if vote type is down.
     * 
     * @param \Media\Entity\VoteEntityInterface $vote
     * 
     * @return bool
     */
    public function isVoteDown(VoteEntityInterface $vote = null)
    {
        return !empty($vote) ? ($vote->getType() === 'down') : false;
    }
    
    /**
     * Check if vote type is up.
     * 
     * @param \Media\Entity\VoteEntityInterface $vote
     * 
     * @return bool
     */
    public function isVoteUp(VoteEntityInterface $vote = null)
    {
        return !empty($vote) ? ($vote->getType() === 'up') : false;
    }
    
    /**
     * Generate URL for media.
     * 
     * @param \Media\Entity\MediaEntityInterface $media
     * 
     * @return string
     */
    public function url(MediaEntityInterface $media, $showAnimation = false)
    {
        // Get bucket URL
        $bucketUrl = $this->options->getBucketUrl();
        
        // Check if thumbnail is required
        if (
            !$showAnimation &&
            $media->getContentType() === 'image/gif' &&
            !empty($media->getThumbnail())
        ) {
            // Return thumbnail
            return $bucketUrl . $media->getThumbnail();
        }
        
        // Return original image
        return $bucketUrl . $media->getReference();
    }
    
    /**
     * Return featured media.
     * 
     * @return int
     */    
    public function getFeatured()
    {
        // Return featured media
        return $this->mediaMapper->selectFeatured();
    }
    
    /**
     * Return points for media.
     * 
     * @param \Media\Entity\MediaEntityInterface $media
     * 
     * @return int
     */    
    public function getPoints(MediaEntityInterface $media)
    {
       return $this->voteMapper->countByMedia($media); 
    }
    
    /**
     * Return number of comments for media.
     * 
     * @param \Media\Entity\MediaEntityInterface $media
     * 
     * @return int
     */    
    public function getComments(MediaEntityInterface $media)
    {
       return $this->commentMapper->countByMedia($media); 
    }
}
