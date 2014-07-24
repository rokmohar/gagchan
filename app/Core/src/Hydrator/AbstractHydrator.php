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
            if (!array_key_exists($key, $this->dataMap)) {
                // Skip iteration
                continue;
            }
            
            // Get data type
            $type = $this->dataMap[$key];
            
            if ($type == 'DateTime' && !is_null($data[$key])) {
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
            if (!array_key_exists($key, $this->dataMap)) {
                // Skip iteration
                continue;
            }
            
            // Get data type
            $type = $this->dataMap[$key];
            
            if ($type == 'boolean' && !is_null($data[$key])) {
                // Convert to boolean
                $data[$key] = (bool) $data[$key];
            }
            else if ($type == 'integer' && !is_null($data[$key])) {
                // Convert to integer
                $data[$key] = (int) $data[$key];
            }
            else if ($type == 'string' && !is_null($data[$key])) {
                // Convert to string
                $data[$key] = (string) $data[$key];
            }
            else if ($type == 'DateTime' && !is_null($data[$key])) {
                // Convert to date
                $data[$key] = new \DateTime($data[$key]);
            }
        }
        
        return parent::hydrate($data, $object);
    }
}