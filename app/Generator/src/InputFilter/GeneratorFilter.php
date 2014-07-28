<?php

namespace Generator\InputFilter;

use Zend\InputFilter\InputFilter;

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
            ->addToken()
        ;
    }
    
    /**
     * Add filter for the top text element.
     *      
     * @return \Generator\InputFilter\GeneratorFilter
     */
    protected function addTop()
    {
        $this->add(array(
            'name'     => 'top',
            'required' => true,
            'filters'  => array(
                //array('name' => 'Zend\Filter\HtmlEntities'),
                array('name' => 'Zend\Filter\StringTrim'),
                array('name' => 'Zend\Filter\StripTags'),
            ),
        ));      
        
        return $this;        
    }
    
    /**
     * Add filter for the bottom text element.
     *      
     * @return \Generator\InputFilter\GeneratorFilter
     */
    protected function addBottom()
    {
        $this->add(array(
            'name'     => 'bottom',
            'required' => true,
            'filters'  => array(
                //array('name' => 'Zend\Filter\HtmlEntities'),
                array('name' => 'Zend\Filter\StringTrim'),
                array('name' => 'Zend\Filter\StripTags'),
            ),
        ));      
        
        return $this;        
    }
    
    /**
     * Add filter for the token element.
     *      
     * @return \Generator\InputFilter\GeneratorFilter
     */
    protected function addToken()
    {
        $this->add(array(
            'name'     => 'token',
            'required' => true,
            'filters'  => array(
                array('name' => 'Zend\Filter\HtmlEntities'),
                array('name' => 'Zend\Filter\StringTrim'),
                array('name' => 'Zend\Filter\StripTags'),
            ),
        ));      
        
        return $this;        
    }
}
