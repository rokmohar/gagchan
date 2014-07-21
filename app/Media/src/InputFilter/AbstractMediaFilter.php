<?php

namespace Media\InputFilter;

use Zend\InputFilter\InputFilter;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
abstract class AbstractMediaFilter extends InputFilter
{
    /**
     * {@inheritDoc}
     */
    public function __construct()
    {
        // Add filters
        $this
            ->addName()
            ->addCategory()
        ;
    }
    
    /**
     * Add filter for form element.
     * 
     * @return \Media\InputFilter\MediaFilter
     */
    protected function addName()
    {
        $this->add(array(
            'name'       => 'name',
            'required'   => true,
            'validators' => array(
                array(
                    'name'    => 'Zend\Validator\stringLength',
                    'options' => array(
                        'min' => 4,
                        'max' => 255,
                    ),
                ),
            ),
            'filters'   => array(
                array('name' => 'HtmlEntities'),
                array('name' => 'stringTrim'),
                array('name' => 'StripTags'),
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add filter for form element.
     * 
     * @return \Media\InputFilter\MediaFilter
     */
    protected function addCategory()
    {
        $this->add(array(
            'name'     => 'category',
            'required' => true,
        ));
        
        return $this;
    }
}