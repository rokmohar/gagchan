<?php

namespace Core\Hydrator\Strategy;

use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class BooleanStrategy implements StrategyInterface
{
    /**
     * {@inheritDoc}
     */
    public function extract($value)
    {
        return ($value == true) ? "1" : "0";
    }
    
    /**
     * {@inheritDoc}
     */
    public function hydrate($value)
    {
        return ($value == 1) ? true : false;
    }
}
