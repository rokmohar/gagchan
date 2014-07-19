<?php

namespace User\View\Helper;

use Zend\View\Helper\AbstractHelper;

use User\Authentication\AuthenticationService;
use User\Mapper\UserMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class UserHelper extends AbstractHelper
{
    /**
     * @var \User\Authentication\AuthenticationService
     */
    protected $authService;
    
    /**
     * @var \User\Mapper\UserMapperInterface
     */
    protected $userMapper;
    
    /**
     * @param \User\Authentication\AuthenticationService $authService
     * @param \User\Mapper\UserMapperInterface           $userMapper
     */
    public function __construct(AuthenticationService $authService, UserMapperInterface $userMapper)
    {
        $this->authService = $authService;
        $this->userMapper  = $userMapper;
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
        return $this->userMapper->selectRowById($id);
    }
    
    /**
     * @return bool
     */
    public function hasIdentity()
    {
        return $this->authService->hasIdentity();
    }
    
    /**
     * @return mixed
     */
    public function getIdentity()
    {
        return $this->authService->getIdentity();
    }
}