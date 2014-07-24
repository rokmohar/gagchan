<?php

namespace User\Hydrator;

use Core\Hydrator\AbstractHydrator;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class RecoverHydrator extends AbstractHydrator
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
        'recovered_at'   => 'DateTime',
        'is_recovered'   => 'boolean',
        'created_at'     => 'DateTime',
        'updated_at'     => 'DateTime',
    );
}