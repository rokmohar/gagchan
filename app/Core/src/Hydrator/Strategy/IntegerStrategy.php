<?php

namespace Core\Hydrator\Strategy;

use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class IntegerStrategy implements StrategyInterface
{
    /**
     * {@inheritDoc}
     */
    public function extract($value)
    {
        return (string) $value;
    }
    
    /**
     * {@inheritDoc}
     */
    public function hydrate($value)
    {
        return (int) $value;
    }
}
