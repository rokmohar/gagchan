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
            ->addDownload()
            ->addPublish()
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
     * Add the download form element.
     * 
     * @return \Generator\Form
     */
    public function addDownload()
    {
        $this->add(array(
            'name' => 'download',
            'options' => array(
                'label' => 'Download',
            ),
            'attributes' => array(
                'type'  => 'Zend\Form\Element\Submit',
                'class' => 'btn btn-primary',
                'value' => 'Download',
            ),
        ));
        
        return $this;
    }    
    
    /**
     * Add the publish form element.
     * 
     * @return \Generator\Form
     */
    public function addPublish()
    {
        $this->add(array(
            'name' => 'publish',
            'options' => array(
                'label' => 'Publish',
            ),
            'attributes' => array(
                'type'  => 'Zend\Form\Element\Submit',
                'class' => 'btn btn-primary',
                'value' => 'Publish',
            ),
        ));
        
        return $this;
    }      
}
