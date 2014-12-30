<?php

namespace Core\Hydrator;

use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
abstract class AbstractHydrator extends ClassMethods
{
    /**
     * {@inheritDoc}
     */
    public function extract($object)
    {
        $data = parent::extract($object);
        
        // Iterate over data
        foreach (array_keys($data) as $key) {
            // Check if array key does not exist
            if (!array_key_exists($key, $this->dataMap) || is_null($data[$key])) {
                // Skip iteration
                continue;
            }
            
            // Get data type
            $type = $this->dataMap[$key];
            
            if ($type == 'DateTime' && $data[$key] instanceof \DateTime) {
                // Format date
                $data[$key] = $data[$key]->format("Y-m-d H:i:s");
            }
        }
        
        return $data;
    }
    
    /**
     * {@inheritDoc}
     */
    public function hydrate(array $data, $object)
    {
        // Iterate over data
        foreach (array_keys($data) as $key) {
            // Check if array key does not exist
            if (!array_key_exists($key, $this->dataMap) || is_null($data[$key])) {
                // Skip iteration
                continue;
            }
            
            // Get data type
            $type = $this->dataMap[$key];
            
            if ($type == 'boolean') {
                // Convert to boolean
                $data[$key] = (bool) $data[$key];
            }
            else if ($type == 'integer') {
                // Convert to integer
                $data[$key] = (int) $data[$key];
            }
            else if ($type == 'string') {
                // Convert to string
                $data[$key] = (string) $data[$key];
            }
            else if ($type == 'DateTime' && !$data[$key] instanceof \DateTime) {
                // Convert to date
                $data[$key] = new \DateTime($data[$key]);
            }
        }
        
        return parent::hydrate($data, $object);
    }
}