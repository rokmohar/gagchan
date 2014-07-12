<?php

namespace Media\Hydrator;

use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class MediaHydrator extends ClassMethods
{
    /**
     * {@inheritDoc}
     */
    public function extract($object)
    {
        return parent::extract($object);
    }

    /**
     * {@inheritDoc}
     */
    public function hydrate(array $data, $object)
    {
        // Check if identifier is not provided
        if (isset($data['category_id']) === false && isset($data['category']) === true) {
            // Merge identifier
            $data['category_id'] = $data['category'];
        }
        
        // Check if identifier is not provided
        if (isset($data['user_id']) === false && isset($data['user']) === true) {
            // Merge identifier
            $data['user_id'] = $data['user'];
        }

        // Unset identifiers
        unset($data['category']);
        unset($data['user']);

        // Get dates
        $createdAt = isset($data['created_at']) ? $data['created_at'] : null;
        $updatedAt = isset($data['updated_at']) ? $data['updated_at'] : null;
        
        // Unset dates
        unset($data['created_at']);
        unset($data['updated_at']);
        
        // Convert data to object
        $data = parent::hydrate($data, $object);
        
        // Check if created at is provided
        if (empty($createdAt) === false) {
            // Set created at
            $object->setCreatedAt(new \DateTime($createdAt));
        }
        
        // Check if updated at is provided
        if (empty($createdAt) === false) {
            // Set updated at
            $object->setUpdatedAt(new \DateTime($updatedAt));
        }

        // Return converted data
        return $data;
    }
}