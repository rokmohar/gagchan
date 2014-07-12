<?php

namespace Media\Hydrator;

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