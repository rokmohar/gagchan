<?php

namespace User\View\Helper;

use Zend\Authentication\AuthenticationServiceInterface;
use Zend\View\Helper\AbstractHelper;

use User\Authentication\AuthenticationServiceAwareInterface;
use User\Mapper\UserMapperAwareInterface;
use User\Mapper\UserMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class UserHelper extends AbstractHelper implements
    AuthenticationServiceAwareInterface,
    UserMapperAwareInterface
{
    /**
     * @var \Zend\Authentication\AuthenticationServiceInterface
     */
    protected $authService;
    
    /**
     * @var \User\Mapper\UserMapperInterface
     */
    protected $userMapper;
    
    /**
     * @param \Zend\Authentication\AuthenticationServiceInterface $authService
     * @param \User\Mapper\UserMapperInterface                    $userMapper
     */
    public function __construct(
        AuthenticationServiceInterface $authService,
        UserMapperInterface $userMapper
    ) {
        $this->setAuthService($authService);
        $this->setUserMapper($userMapper);
    }
    
    /**
     * {@inheritDoc}
     */
    public function __invoke()
    {
        return $this;
    }
    
    /**
     * Return the user.
     * 
     * @return mixed
     */
    public function findById($id)
    {
        return $this->getUserMapper()->selectRowById($id);
    }
    
    /**
     * Check whether the user has identity.
     * 
     * @return bool
     */
    public function hasIdentity()
    {
        return $this->getAuthService()->hasIdentity();
    }
    
    /**
     * Returnthe identity.
     * 
     * @return mixed
     */
    public function getIdentity()
    {
        return $this->getAuthService()->getIdentity();
    }

    /**
     * {@inheritDoc}
     */
    public function getAuthService()
    {
        return $this->authService;
    }

    /**
     * {@inheritDoc}
     */
    public function setAuthService(AuthenticationServiceInterface $authService)
    {
        $this->authService = $authService;
        
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUserMapper()
    {
        return $this->userMapper;
    }

    /**
     * {@inheritDoc}
     */
    public function setUserMapper(UserMapperInterface $userMapper)
    {
        $this->userMapper = $userMapper;
        
        return $this;
    }

}