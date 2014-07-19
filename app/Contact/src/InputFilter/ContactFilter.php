<?php

namespace Contact\InputFilter;

use Zend\InputFilter\InputFilter;
use Zend\Validator\Hostname as HostnameValidator;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <rok.zaloznik@gmail.com>
 */
class ContactFilter extends InputFilter
{
    /**
     * {@inheritDoc}
     */    
    public function __construct()
    {
        // Add input filters
        $this
            ->addFrom()
            ->addSubject()
            ->addBody()
        ;
    }
    
    /**
     * Add filter for "From" field
     *      
     * @return \Contact\InputFilter
     */
    protected function addFrom() 
    {
        $this->add(array(
            'name' => 'from',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'EmailAddress',
                    'options' => array(
                        'allow' => HostnameValidator::ALLOW_DNS,
                        'domain' => true,
                    ),
                ),
            ),
        ));        
        
        return $this;
    }
    
    /**
     * Add filter for subject field
     *      
     * @return \Contact\InputFilter 
     */
    protected function addSubject()
    {
        $this->add(array(
            'name' => 'subject',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags',
                ),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 2,
                        'max' => 140,
                    ),
                ),
            ),
        ));      
        
        return $this;        
    }
    
    /**
     * Add filter for body text area
     *      
     * @return \Contact\InputFilter
     */
    protected function addBody()
    {
        $this->add(array(
            'name' => 'body',
            'required' => true,
        ));     
        
        return $this;        
    }
}