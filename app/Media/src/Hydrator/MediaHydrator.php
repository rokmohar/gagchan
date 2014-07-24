<?php

namespace Media\Hydrator;

use Core\Hydrator\AbstractHydrator;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class MediaHydrator extends AbstractHydrator
{
    /**
     * @var array
     */
    protected $dataMap = array(
        'id'           => 'integer',
        'slug'         => 'string',
        'name'         => 'string',
        'reference'    => 'string',
        'thumbnail'    => 'string',
        'user_id'      => 'integer',
        'category_id'  => 'integer',
        'height'       => 'integer',
        'width'        => 'integer',
        'size'         => 'integer',
        'content_type' => 'string',
        'is_enabled'   => 'boolean',
        'is_featured'  => 'boolean',
        'created_at'   => 'DateTime',
        'updated_at'   => 'DateTime',
    );
}