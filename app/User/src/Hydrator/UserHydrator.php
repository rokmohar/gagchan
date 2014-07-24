<?php

namespace User\Hydrator;

use Core\Hydrator\AbstractHydrator;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class UserHydrator extends AbstractHydrator
{
    /**
     * @var array
     */
    protected $dataMap = array(
        'id'           => 'integer',
        'username'     => 'string',
        'email'        => 'string',
        'password'     => 'string',
        'state'        => 'integer',
        'created_at'   => 'DateTime',
        'updated_at'   => 'DateTime',
    );
}