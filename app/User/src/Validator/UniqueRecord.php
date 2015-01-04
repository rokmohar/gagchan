<?php

namespace User\Validator;

use User\Entity\UserEntityInterface;
use User\Mapper\UserMapperInterface;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class UniqueRecord extends AbstractDb
{
    /**#@+*/
    const ERROR_RECORD_FOUND = 'recordFound';
    /**#@-*/
    
    /**
     * @var array
     */
    protected $messageTemplates = array(
        self::ERROR_RECORD_FOUND => "A record matching the input was found",
    );
    
    
    /**
     * {@inheritDoc}
     */
    public function isValid($value, $context = null)
    {
        // Find a match
        $match = $this->mapper->selectRow(array(
            $this->field => $value,
        ));
        
        // Return true, iff match is empty
        if (empty($match)) {
            return true;
        }
        
        // Get identifiers
        $expectedIdentifiers = $this->getExpectedIdentifiers($context);
        $foundIdentifiers    = $this->getFoundIdentifiers($match);

        // Return true, iff identifiers are same
        if (count(array_diff_assoc($expectedIdentifiers, $foundIdentifiers)) === 0) {
            return true;
        }
        
        // Add error
        $this->error(self::ERROR_RECORD_FOUND);
        
        // Not found
        return false;
    }
    
    /**
     * Return expected identifiers.
     * 
     * @return array
     */
    protected function getExpectedIdentifiers(array $context)
    {
        if (!array_key_exists('id', $context)) {
            throw new \InvalidArgumentException("Identifier is required, nothing given.");
        }
        
        return array(
            'id' => $context['id'],
        );
    }
    
    /**
     * Return found identifiers.
     * 
     * @return array
     */
    protected function getFoundIdentifiers(UserEntityInterface $match)
    {
        return array(
            'id' => $match->getId(),
        );
    }
}