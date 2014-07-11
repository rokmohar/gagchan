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
        // Get dates
        $createdAt = $data['created_at'];
        $updatedAt = $data['updated_at'];
        
        // Reset dates
        unset($data['created_at']);
        unset($data['updated_at']);
        
        // Convert string to date
        $data = parent::hydrate($data, $object);
        
        // Create dates
        $object->setCreatedAt(new \DateTime($createdAt));
        $object->setUpdatedAt(new \DateTime($updatedAt));
        
        return $data;
    }
}