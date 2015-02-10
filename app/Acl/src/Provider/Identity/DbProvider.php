<?php

namespace Acl\Provider\Identity;

use Acl\Mapper\RoleMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class DbProvider implements ProviderInterface
{
    /**
     * @var \Acl\Mapper\RoleMapperInterface
     */
    protected $roleMapper;
    
    /**
     * @param \Acl\Mapper\RoleMapperInterface $roleMapper
     */
    public function __construct(RoleMapperInterface $roleMapper)
    {
        $this->roleMapper = $roleMapper;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getIdentityRoles()
    {
        $roles = array();
        
        return $roles;
    }
}
