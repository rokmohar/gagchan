<?php

namespace Generator\Hydrator;

use Core\Hydrator\AbstractHydrator;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class PrototypeHydrator extends AbstractHydrator
{
    /**
     * @var array
     */
    protected $dataMap = array(
        'id'           => 'integer',
        'slug'         => 'string',
        'name'         => 'string',
        'refenrece'    => 'string',
        'height'       => 'integer',
        'widht'        => 'integer',
        'size'         => 'integer',
        'content_type' => 'string',
        'created_at'   => 'DateTime',
        'updated_at'   => 'DateTime',
    );
}