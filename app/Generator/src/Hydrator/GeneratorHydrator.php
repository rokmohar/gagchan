<?php

namespace Generator\Hydrator;

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
        'created_at'  => 'DateTime',
        'updated_at'  => 'DateTime',
    );
}