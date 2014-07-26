<?php

namespace Generator\InputFilter;

use Zend\InputFilter\InputFilter;
use Zend\Validator\Hostname;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class GeneratorFilter extends InputFilter
{
    /**
     * {@inheritDoc}
     */    
    public function __construct()
    {
        // Add input filters
        $this
            ->addTop()
            ->addBottom()
        ;
    }
    
    /**
     * Add filter for top text.
     *      
     * @return \Generator\InputFilter\GeneratorFilter
     */
    protected function addTop()
    {
        $this->add(array(
            'name'       => 'top',
            'required'   => true,
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 0,
                        'max' => 80,
                    ),
                ),
            ),
            'filters' => array(
                array('name' => 'StringTrim'),
                array('name' => 'StripTags'),
            ),
        ));      
        
        return $this;        
    }
    
    /**
     * Add filter for bottom text.
     *      
     * @return \Generator\InputFilter\GeneratorFilter
     */
    protected function addBottom()
    {
        $this->add(array(
            'name'       => 'bottom',
            'required'   => false,
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 0,
                        'max' => 80,
                    ),
                ),
            ),
            'filters' => array(
                array('name' => 'StringTrim'),
                array('name' => 'StripTags'),
            ),
        ));      
        
        return $this;        
    }
    
}