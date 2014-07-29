<?php

namespace User\Validator;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class RecordExists extends AbstractDb
{
    /**#@+*/
    const ERROR_NO_RECORD_FOUND = 'noRecordFound';
    /**#@-*/
    
    /**
     * @var array
     */
    protected $messageTemplates = array(
        self::ERROR_NO_RECORD_FOUND => "No record matching the input was found",
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
        
        // Check if match is not empty
        if (!empty($match)) {
            // Record found
            return true;
        }
        
        // Add error
        $this->error(self::ERROR_NO_RECORD_FOUND);
        
        // No record found
        return false;
    }
}