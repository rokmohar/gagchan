<?php

namespace Generator\InputFilter;

use Zend\InputFilter\InputFilter;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class PreviewFilter extends InputFilter
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
            ->addSource()
            ->addToken()
        ;
    }
    
    /**
     * Add filter for the top text element.
     *      
     * @return \Generator\InputFilter\PreviewFilter
     */
    protected function addTop()
    {
        $this->add(array(
            'name'     => 'top',
            'required' => false,
            'filters'  => array(
                array('name' => 'Zend\Filter\HtmlEntities'),
                array('name' => 'Zend\Filter\StringTrim'),
                array('name' => 'Zend\Filter\StripTags'),
            ),
        ));      
        
        return $this;        
    }
    /**
     * Add filter for the bottom text element.
     *      
     * @return \Generator\InputFilter\PreviewFilter
     */
    protected function addBottom()
    {
        $this->add(array(
            'name'     => 'bottom',
            'required' => false,
            'filters'  => array(
                array('name' => 'Zend\Filter\HtmlEntities'),
                array('name' => 'Zend\Filter\StringTrim'),
                array('name' => 'Zend\Filter\StripTags'),
            ),
        ));      
        
        return $this;        
    }
    
    /**
     * Add filter for the source element.
     *      
     * @return \Generator\InputFilter\PreviewFilter
     */
    protected function addSource()
    {
        $this->add(array(
            'name'     => 'source',
            'required' => true,
            'filters'  => array(
                array('name' => 'Zend\Filter\HtmlEntities'),
                array('name' => 'Zend\Filter\StringTrim'),
                array('name' => 'Zend\Filter\StripTags'),
            ),
        ));      
        
        return $this;        
    }
    
    /**
     * Add filter for the token element.
     *      
     * @return \Generator\InputFilter\PreviewFilter
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