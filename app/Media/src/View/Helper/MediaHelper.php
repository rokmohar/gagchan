<?php

namespace Media\View\Helper;

use Zend\Authentication\AuthenticationService;
use Zend\View\Helper\AbstractHelper;

use Media\Entity\MediaEntityInterface;
use Media\Entity\VoteEntityInterface;
use Media\Mapper\CommentMapperInterface;
use Media\Mapper\MediaMapperInterface;
use Media\Mapper\VoteMapperInterface;
use Media\Options\ModuleOptions;

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
     * @var \Media\Options\ModuleOptions $options
     */
    protected $options;
    
    /**
     * @param \Media\Mapper\MediaMapperInterface         $mediaMapper
     * @param \Media\Mapper\CommentMapperInterface       $commentMapper
     * @param \Media\Mapper\VoteMapperInterface          $voteMapper
     * @param \Zend\Authentication\AuthenticationService $authService
     * @param \Media\Options\ModuleOptions               $options
     */
    public function __construct(
        MediaMapperInterface $mediaMapper,
        CommentMapperInterface $commentMapper,
        VoteMapperInterface $voteMapper,
        AuthenticationService $authService,
        ModuleOptions $options
    ) {
        $this->mediaMapper   = $mediaMapper;
        $this->commentMapper = $commentMapper;
        $this->voteMapper    = $voteMapper;
        $this->authService   = $authService;
        $this->options       = $options;
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
        
        // Check if user is empty
        if (empty($user) === true) {
            // Return void
            return null;
        }
        
        // Return vote
        return $this->voteMapper->selectRowByMedia($media, $user);
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
    public function url(MediaEntityInterface $media, $showThumbnail = false)
    {
        // Get bucket URL
        $bucketUrl = $this->options->getBucketUrl();
        
        // Check if thumbnail is required
        if ($showThumbnail === true && $media->getThumbnail() !== null) {
            // Return thumbnail
            return $bucketUrl . $media->getThumbnail();
        }
        
        // Return original image
        return $bucketUrl . $media->getReference();
    }
    
    /**
     * Return featured media.
     * 
     * @return Integer
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
     * @return Integer
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
     * @return Integer
     */    
    public function getComments(MediaEntityInterface $media)
    {
       return $this->commentMapper->countByMedia($media); 
    }
}
