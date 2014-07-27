<?php

namespace Generator\Form;

use Media\Form\MediaForm;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class PublishForm extends MediaForm
{
    
    /**
     * @param string $name
     * @param array  $options
     */
    public function __construct($name, array $options = array())
    {
        parent::__construct($name, $options);
        
        // Add elements
        $this
            ->addToken()
        ;
    }
    
    /**
     * Add the token element.
     * 
     * @return \Generator\Form\PublishForm
     */
    public function addToken()
    {
        $this->add(array(
            'name' => 'token',
            'type' => 'Zend\Form\Element\Hidden',
        ));
        
        return $this;
    }
    
    /**
     * Set the token value.
     * 
     * @param string $value
     */
    public function setTokenValue($value)
    {
        // Check if token element exists
        if ($this->has('token')) {
            // Set token value
            $this->get('token')->setValue($value);
        }
        
        
        return $this;
    }
}