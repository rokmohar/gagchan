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
            ->addEmail()
            ->addSubject()
            ->addMessage()
        ;
    }
    
    /**
     * Add filter for email address.
     *      
     * @return \Contact\InputFilter\ContactFilter
     */
    protected function addEmail() 
    {
        $this->add(array(
            'name'       => 'email',
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
            'validators' => array(),
            'filters' => array(
                array('name' => 'stringTrim'),
                array('name' => 'StripTags'),
            ),
        ));      
        
        return $this;        
    }
    
    /**
     * Add filter for message.
     *      
     * @return \Contact\InputFilter\ContactFilter
     */
    protected function addMessage()
    {
        $this->add(array(
            'name'       => 'message',
            'required'   => true,
            'validators' => array(),
            'filters' => array(
                array('name' => 'stringTrim'),
                array('name' => 'StripTags'),
            ),
        ));     
        
        return $this;        
    }
}