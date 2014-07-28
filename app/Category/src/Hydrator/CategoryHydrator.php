<?php
namespace Category\Hydrator;
use Core\Hydrator\AbstractHydrator;
/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class CategoryHydrator extends AbstractHydrator
{
    /**
     * @var array
     */
    protected $dataMap = array(
        'id'         => 'integer',
        'slug'       => 'string',
        'name'       => 'string',
        'priority'   => 'integer',
        'created_at' => 'DateTime',
        'updated_at' => 'DateTime',
    );
}