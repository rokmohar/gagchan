<?php

namespace User\View\Helper;

use Zend\View\Helper\AbstractHelper;

use ZfcUser\Mapper\UserInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class UserHelper extends AbstractHelper
{
    /**
     * @var \ZfcUser\Mapper\UserInterface
     */
    protected $userMapper;
    
    /**
     * @param \ZfcUser\Mapper\UserInterface $userMapper
     */
    public function __construct(UserInterface $userMapper)
    {
        $this->userMapper = $userMapper;
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
     * Return user details.
     * 
     * @return mixed
     */
    public function findById($id)
    {
        return $this->userMapper->findById($id);
    }
}