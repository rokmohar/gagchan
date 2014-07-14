<?php

namespace Media\View\Helper;

use Zend\Authentication\AuthenticationService;
use Zend\View\Helper\AbstractHelper;

use Media\Entity\MediaEntityInterface;
use Media\Entity\ResponseEntityInterface;
use Media\Mapper\MediaMapperInterface;
use Media\Mapper\ResponseMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
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
     * @var \Media\Mapper\MediaMapperInterface
     */
    protected $mediaMapper;
    
    /**
     * @var \Media\Mapper\ResponseMapperInterface
     */
    protected $responseMapper;
    
    /**
     * 
     */
    
    /**
     * @param \Media\Mapper\MediaMapperInterface         $mediaMapper
     * @param \Media\Mapper\ResponseMapperInterface      $responseMapper
     * @param \Zend\Authentication\AuthenticationService $authService
     */
    public function __construct(
        MediaMapperInterface $mediaMapper,
        ResponseMapperInterface $responseMapper,
        AuthenticationService $authService
    ) {
        $this->mediaMapper    = $mediaMapper;
        $this->responseMapper = $responseMapper;
        $this->authService    = $authService;
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
     * Get response for media.
     * 
     * @param \Media\Entity\MediaEntityInterface $media
     * 
     * @return mixed
     */
    public function getResponse(MediaEntityInterface $media)
    {
        // Get user
        $user = $this->authService->getIdentity();
        
        // Return response
        return ($user !== null) ? $this->responseMapper->selectOneByMedia($media->getId(), $user->getId()) : null;
    }
    
    /**
     * Check if response type is down.
     * 
     * @param \Media\Entity\ResponseEntityInterface $response
     * 
     * @return Boolean
     */
    public function isResponseDown(ResponseEntityInterface $response)
    {
        return ($response->getType() === 'down');
    }
    
    /**
     * Check if response type is up.
     * 
     * @param \Media\Entity\ResponseEntityInterface $response
     * 
     * @return Boolean
     */
    public function isResponseUp(ResponseEntityInterface $response)
    {
        return ($response->getType() === 'up');
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
}