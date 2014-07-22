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
        'request_at'   => 'DateTime',
        'confirmed_at' => 'DateTime',
        'is_confirmed' => 'boolean',
        'created_at'   => 'DateTime',
        'updated_at'   => 'DateTime',
    );
}