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
        
        foreach ($data as $d) {
            // Check if it needs a conversion
            if (is_bool($d) === true) {
                // Convert to integer
                $d = (int) $d;
            }
            else if ($d instanceof \DateTime) {
                // Format a string
                $d = $d->format('Y-m-d H:i:s');
            }
        }
        
        return $data;
    }

    /**
     * {@inheritDoc}
     */
    public function hydrate(array $data, $object)
    {
        if (!isset($data['category_id']) && isset($data['category'])) {
            // Merge identifier
            $data['category_id'] = $data['category'];
        }
        
        if (!isset($data['user_id']) && isset($data['user'])) {
            // Merge identifier
            $data['user_id'] = $data['user'];
        }

        unset($data['category']);
        unset($data['user']);
        
        if (isset($data['is_featured']) === true) {
            // Convert to boolean
            $data['is_featured'] = (bool) $data['is_featured'];
        }
        
        if (isset($data['created_at']) === true) {
            // Convert to date
            $data['created_at'] = new \DateTime($data['created_at']);
        }
        
        if (isset($data['updated_at']) === true) {
            // Convert to date
            $data['updated_at'] = new \DateTime($data['updated_at']);
        }

        return parent::hydrate($data, $object);
    }
}