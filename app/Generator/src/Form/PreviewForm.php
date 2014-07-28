<?php

namespace Generator\Form;

use Zend\Form\Form;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class PreviewForm extends Form
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
        
        // Add elements
        $this
            ->addBottom()
            ->addSource()
            ->addToken()
            ->addTop()
        ;
    }
    
    /**
     * Add the bottom text element.
     * 
     * @return \Generator\Form\PreviewForm
     */
    public function addBottom()
    {
        $this->add(array(
            'name' => 'bottom',
            'type' => 'Zend\Form\Element\Text',
        ));
        
        return $this;
    }
    
    /**
     * Add the source element.
     * 
     * @return \Generator\Form\PreviewForm
     */
    public function addSource()
    {
        $this->add(array(
            'name' => 'source',
            'type' => 'Zend\Form\Element\Text',
        ));
        
        return $this;
    }
    
    /**
     * Add the top text element.
     * 
     * @return \Generator\Form\PreviewForm
     */
    public function addTop()
    {
        $this->add(array(
            'name' => 'top',
            'type' => 'Zend\Form\Element\Text',
        ));
        
        return $this;
    }
    
    /**
     * Add the token element.
     * 
     * @return \Generator\Form\PreviewForm
     */
    public function addToken()
    {
        $this->add(array(
            'name' => 'token',
            'type' => 'Zend\Form\Element\Text',
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