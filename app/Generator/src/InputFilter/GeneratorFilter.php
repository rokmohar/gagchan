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
            ->addTopBottom()
        ;
    }
    
    /**
     * Add filter for top and bottom text on meme
     *      
     * @return \Generator\InputFilter\GeneratorFilter
     */
    protected function addTopBottom()
    {
        $this->add(array(
            'name' => 'topbottom',
            'required' => true,
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