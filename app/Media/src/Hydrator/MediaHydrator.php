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
        $data = parent::extract($object);
        
        if (isset($data['is_featured']) && is_bool($data['is_featured'])) {
            // Set to boolean
            $data['is_featured'] = (Integer) $data['is_featured'];
        }
        
        if (isset($data['created_at']) && $data['created_at'] instanceof \DateTime) {
            // Convert from date
            $data['created_at'] = $data['created_at']->format('Y-m-d H:i:s');
        }
        
        if (isset($data['updated_at']) && $data['updated_at'] instanceof \DateTime) {
            // Convert from date
            $data['updated_at'] = $data['updated_at']->format('Y-m-d H:i:s');
        }
        
        return $data;
    }

    /**
     * {@inheritDoc}
     */
    public function hydrate(array $data, $object)
    {
        if (!isset($data['category_id']) && isset($data['category'])) {
            // Merge category identifier
            $data['category_id'] = $data['category'];
        }
        
        if (!isset($data['user_id']) && isset($data['user'])) {
            // Merge category identifier
            $data['user_id'] = $data['user'];
        }

        unset($data['category']);
        unset($data['user']);
        
        if (isset($data['is_featured']) && !is_bool($data['is_featured'])) {
            // Set to boolean
            $data['is_featured'] = (Boolean) $data['is_featured'];
        }
        
        if (isset($data['created_at']) && !$data['created_at'] instanceof \DateTime) {
            // Convert to date
            $data['created_at'] = new \DateTime($data['created_at']);
        }
        
        if (isset($data['updated_at']) && !$data['updated_at'] instanceof \DateTime) {
            // Convert to date
            $data['updated_at'] = new \DateTime($data['updated_at']);
        }

        return parent::hydrate($data, $object);
    }
}