<?php

namespace User\Validator;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class NoRecordExists extends AbstractDb
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
    public function isValid($value)
    {
        // Find match
        $match = $this->mapper->selectRow(array(
            $this->field => $value,
        ));
        
        // Check if match is empty
        if (empty($match)) {
            // No record found
            return true;
        }
        
        // Add error
        $this->error(self::ERROR_RECORD_FOUND);
        
        // Record found
        return false;
    }
}