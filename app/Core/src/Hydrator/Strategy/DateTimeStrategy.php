<?php

namespace Core\Hydrator\Strategy;

use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class DateTimeStrategy implements StrategyInterface
{
    /**
     * {@inheritDoc}
     */
    public function extract($value)
    {
        return ($value instanceof \DateTime) ? $value->format("Y-m-d H:i:s") : $value;
    }
    
    /**
     * {@inheritDoc}
     */
    public function hydrate($value)
    {
        return (is_string($value) && !empty($value)) ? new \DateTime($value) : $value;
    }
}
