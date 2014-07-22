<?php

namespace Generator\Form;

use Zend\Form\Form;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class GeneratorForm extends Form
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
            ->addTop()
            ->addBottom()
            ->addSubmit()
        ;
    }
    
    /**
     * Add the top positioned text
     * 
     * @return \Generator\Form
     */
    protected function addTop()
    {
        $this->add(array(
            'name'    => 'top',
            'options' => array(
                'label' => 'Top Text',
            ),
            'attributes' => array(
                'type'        => 'Zend\Form\Element\Text',
                'class'       => 'form-control',
                'placeholder' => 'Top Text',
            ),
        ));
        
        return $this;
    }    
    
    /**
     * Add the bottom positioned text
     * 
     * @return \Generator\Form
     */
    protected function addBottom()
    {
        $this->add(array(
            'name'    => 'bottom',
            'options' => array(
                'label' => 'Bottom Text',
            ),
            'attributes' => array(
                'type'        => 'Zend\Form\Element\Text',
                'class'       => 'form-control',
                'placeholder' => 'Bottom Text',
            ),            
        ));
        
        return $this;
    }    
    
    /**
     * Add the submit form element.
     * 
     * @return \Generator\Form
     */
    public function addSubmit()
    {
        $this->add(array(
            'name' => 'Send',
            'options' => array(
                'label' => 'Send',
            ),
            'attributes' => array(
                'type'  => 'Zend\Form\Element\Submit',
                'class' => 'btn btn-primary',
                'value' => 'Send',
            ),
        ));
        
        return $this;
    }    
}
