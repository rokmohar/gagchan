<?php

namespace OAuth\Hydrator;

use Core\Hydrator\AbstractHydrator;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class OAuthHydrator extends AbstractHydrator
{
    /**
     * @var array
     */
    protected $dataMap = array(
        'id'          => 'integer',
        'user_id'     => 'integer',
        'provider'    => 'string',
        'provider_id' => 'string',
        'created_at'  => 'DateTime',
        'updated_at'  => 'DateTime',
    );
}