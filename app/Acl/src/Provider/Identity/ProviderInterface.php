<?php

namespace Acl\Provider\Identity;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface ProviderInterface
{
    /**
     * @return array
     */
    public function getIdentityRoles();
}
