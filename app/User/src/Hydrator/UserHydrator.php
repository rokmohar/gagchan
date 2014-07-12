<?php

namespace User\Hydrator;

use Zend\Stdlib\Hydrator\ClassMethods;

use ZfcUser\Entity\UserInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class UserHydrator extends ClassMethods
{
    /**
     * {@inheritDoc}
     */
    public function extract($object)
    {
        if (!$object instanceof UserInterface) {
            throw new \InvalidArgumentException(
                'Expected an instance of ZfcUser\Entity\UserInterface'
            );
        }
        
        return parent::extract($object);
    }
    
    /**
     * {@inheritDoc}
     */
    public function hydrate(array $data, $object)
    {
        if (!$object instanceof UserInterface) {
            throw new \InvalidArgumentException(
                'Expectedn an instance of ZfcUser\Entity\UserInterface'
            );
        }
        
        return parent::hydrate($data, $object);
    }
}
