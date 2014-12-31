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
        if (!$value instanceof \DateTime) {
            // Throw an exception
            throw new \InvalidArgumentException(sprintf(
                "Expected instance of DateTime, \"%\" given",
                is_object($value) ? get_class($value) : gettype($value)
            ));
        }
        
        return $value->format("Y-d-m H:i:s");
    }
    
    /**
     * {@inheritDoc}
     */
    public function hydrate($value)
    {
        // Create DateTime
        return new \DateTime($value);
    }
}
