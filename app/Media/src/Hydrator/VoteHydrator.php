<?php

namespace Media\Hydrator;

use Core\Hydrator\AbstractHydrator;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class VoteHydrator extends AbstractHydrator
{
    /**
     * @var array
     */
    protected $dataMap = array(
        'id'         => 'integer',
        'media_id'   => 'integer',
        'user_id'    => 'integer',
        'type'       => 'string',
        'created_at' => 'DateTime',
        'updated_at' => 'DateTime',
    );
}