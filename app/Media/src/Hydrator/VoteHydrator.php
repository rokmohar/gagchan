<?php

namespace Media\Hydrator;

use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class VoteHydrator extends ClassMethods
{
    /**
     * {@inheritDoc}
     */
    public function extract($object)
    {
        $data = parent::extract($object);
        
        foreach ($data as $d) {
            // Check if it needs a conversion
            if ($d instanceof \DateTime) {
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
        if (!isset($data['media_id']) && isset($data['media'])) {
            // Merge identifier
            $data['media_id'] = $data['media'];
        }
        
        if (!isset($data['user_id']) && isset($data['user'])) {
            // Merge identifier
            $data['user_id'] = $data['user'];
        }

        unset($data['media']);
        unset($data['user']);
        
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