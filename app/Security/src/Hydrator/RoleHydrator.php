<?php

namespace Security\Hydrator;

use Core\Hydrator\AbstractHydrator;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class RoleHydrator extends AbstractHydrator
{
    /**
     * @var array
     */
    protected $dataMap = array(
        'id'         => 'integer',
        'name'       => 'string',
        'status'     => 'integer',
        'created_at' => 'DateTime',
        'updated_at' => 'DateTime',
    );
}