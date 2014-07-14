<?php

namespace Media\InputFilter;

use Zend\InputFilter\InputFilter;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class VoteFilter extends InputFilter
{
    /**
     * {@inheritDoc}
     */
    public function __construct()
    {
        // Add input filters
        $this
            ->addSlug()
            ->addType()
        ;
    }
    
    /**
     * Add slug input filter.
     * 
     * @return \Media\InputFilter\MediaFilter
     */
    public function addSlug()
    {
        $this->add(array(
            'name'     => 'slug',
            'required' => true,
        ));
        
        return $this;
    }
    
    /**
     * Add type input filter.
     * 
     * @return \Media\InputFilter\MediaFilter
     */
    public function addType()
    {
        $this->add(array(
            'name'       => 'type',
            'required'   => true,
            'validators' => array(
                array(
                    'name'    => 'InArray',
                    'options' => array(
                        'haystack' => array('up', 'down'),
                    ),
                ),
            ),
        ));
        
        return $this;
    }
}