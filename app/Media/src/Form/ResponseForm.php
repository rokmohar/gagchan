<?php

namespace Media\Form;

use Zend\Form\Form;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class ResponseForm extends Form
{
    /**
     * @param String $name
     */
    public function __construct($name)
    {
        parent::__construct($name);
        
        // Add form elements
        $this
            ->addSlug()
            ->addType()
        ;
    }
    
    /**
     * Add slug form element.
     * 
     * @return \Media\Form\MediaForm
     */
    protected function addSlug()
    {
        $this->add(array(
            'name'    => 'slug',
            'options' => array(
                'label' => 'Slug',
            ),
            'attributes' => array(
                'type' => 'text',
            ),
        ));
        
        return $this;
    }
    /**
     * Add type form element.
     * 
     * @return \Media\Form\MediaForm
     */
    protected function addType()
    {
        $this->add(array(
            'name'    => 'type',
            'options' => array(
                'label' => 'Type',
            ),
            'attributes' => array(
                'type' => 'text',
            ),
        ));
        
        return $this;
    }
}