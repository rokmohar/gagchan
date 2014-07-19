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
     * @var \Media\Options\ModuleOptions $options
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
        if (empty($user) === false) {
            // Select row from database
            $result = $this->voteMapper->selectRowByMedia($media, $user);
            
            // Return result
            return (empty($result) === false) ? $result : null;
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
        return ($vote !== null) ? ($vote->getType() === 'down') : false;
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
        return ($vote !== null) ? ($vote->getType() === 'up') : false;
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
