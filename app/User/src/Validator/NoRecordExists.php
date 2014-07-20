<?php

namespace User\Validator;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class NoRecordExists extends AbstractDb
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
        
        // Check if match is empty
        if (empty($match) === true) {
            // No record found
            return true;
        }
        
        // Add error
        $this->error(self::ERROR_RECORD_FOUND);
        
        // Record found
        return false;
    }
}