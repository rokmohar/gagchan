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
        'is_enabled'  => 'boolean',
        'is_featured' => 'boolean',
        'created_at'  => 'DateTime',
        'updated_at'  => 'DateTime',
    );
}