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
            ->addCategoryId()
        ;
    }
    
    /**
     * Add filter for the name element.
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
     * Add filter for the category element.
     * 
     * @return \Media\InputFilter\MediaFilter
     */
    protected function addCategoryId()
    {
        $this->add(array(
            'name'     => 'category_id',
            'required' => true,
        ));
        
        return $this;
    }
    
    /**
     * Add filter for the delay at form element.
     * 
     * @return \Media\InputFilter\MediaFilter
     */
    public function addDelayAt()
    {
        $this->add(array(
            'name'     => 'delay_at',
            'required' => false,
        ));
        
        return $this;
    }
}