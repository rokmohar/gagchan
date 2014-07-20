<?php

namespace User\Validator;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class RecordExists extends AbstractDb
{
    /**
     * {@inheritDoc}
     */
    public function isValid($value)
    {
        // Get where
        $where = array();
        
        $where[$this->field] = $value;
        
        // Find match
        $match = $this->mapper->selectRow($where);
        
        // Check if match is not empty
        if (empty($match) === false) {
            // Record found
            return true;
        }
        
        // Add error
        $this->error(self::ERROR_NO_RECORD_FOUND);
        
        // No record found
        return false;
    }
}