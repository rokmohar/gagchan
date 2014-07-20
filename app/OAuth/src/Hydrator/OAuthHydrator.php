<?php

namespace OAuth\Hydrator;

use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class OAuthHydrator extends ClassMethods
{
    /**
     * {@inheritDoc}
     */
    public function extract($object)
    {
        $data = parent::extract($object);
        
        foreach ($data as $element) {
            // Check if element needs conversion
            if ($element instanceof \DateTime) {
                // Convert to string
                $element = $element->format('Y-m-d H:i:s');
            }
        }
        
        return $data;
    }

    /**
     * {@inheritDoc}
     */
    public function hydrate(array $data, $object)
    {
        // Check if created at exists
        if (isset($data['created_at'])) {
            // Convert to date
            $data['created_at'] = new \DateTime($data['created_at']);
        }
        
        // Check if updated at exists
        if (isset($data['updated_at'])) {
            // Convert to date
            $data['updated_at'] = new \DateTime($data['updated_at']);
        }

        return parent::hydrate($data, $object);
    }
}