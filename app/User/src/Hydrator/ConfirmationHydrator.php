<?php

namespace User\Hydrator;

use Core\Hydrator\AbstractHydrator;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class ConfirmationHydrator extends AbstractHydrator
{
    /**
     * @var array
     */
    protected $dataMap = array(
        'id'             => 'integer',
        'user_id'        => 'integer',
        'email'          => 'string',
        'remote_address' => 'string',
        'request_at'     => 'DateTime',
        'request_token'  => 'string',
        'confirmed_at'   => 'DateTime',
        'is_confirmed'   => 'boolean',
        'created_at'     => 'DateTime',
        'updated_at'     => 'DateTime',
    );
}