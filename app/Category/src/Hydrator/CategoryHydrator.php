<?php

namespace Category\Hydrator;

use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class CategoryHydrator extends ClassMethods
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