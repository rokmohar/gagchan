<?php

namespace Contact\InputFilter;

use Zend\InputFilter\InputFilter;
use Zend\Validator\Hostname;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
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
     * Add filter for email address.
     *      
     * @return \Contact\InputFilter\ContactFilter
     */
    protected function addFrom() 
    {
        $this->add(array(
            'name'       => 'from',
            'required'   => true,
            'validators' => array(
                array(
                    'name' => 'EmailAddress',
                    'options' => array(
                        'allow'  => Hostname::ALLOW_DNS,
                        'domain' => true,
                    ),
                ),
            ),
            'filters' => array(
                array('name' => 'stringTrim'),
                array('name' => 'StripTags'),
            ),
        ));        
        
        return $this;
    }
    
    /**
     * Add filter for subject.
     *      
     * @return \Contact\InputFilter\ContactFilter
     */
    protected function addSubject()
    {
        $this->add(array(
            'name' => 'subject',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'stringLength',
                    'options' => array(
                        'min' => 4,
                        'max' => 32,
                    ),
                ),
            ),
            'filters' => array(
                array('name' => 'stringTrim'),
                array('name' => 'StripTags'),
            ),
        ));      
        
        return $this;        
    }
    
    /**
     * Add filter for body.
     *      
     * @return \Contact\InputFilter\ContactFilter
     */
    protected function addBody()
    {
        $this->add(array(
            'name'       => 'body',
            'required'   => true,
            'validators' => array(
                array(
                    'name' => 'stringLength',
                    'options' => array(
                        'min' => 16,
                        'max' => 4096,
                    ),
                ),
            ),
            'filters' => array(
                array('name' => 'stringTrim'),
                array('name' => 'StripTags'),
            ),
        ));     
        
        return $this;        
    }
}