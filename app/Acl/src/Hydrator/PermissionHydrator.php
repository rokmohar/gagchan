<?php

namespace Acl\Hydrator;

use Core\Hydrator\AbstractHydrator;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class PermissionHydrator extends AbstractHydrator
{
    /**
     * @var array
     */
    protected $dataMap = array(
        'id'          => 'integer',
        'resource_id' => 'integer',
        'name'        => 'string',
        'created_at'  => 'DateTime',
        'updated_at'  => 'DateTime',
    );
}