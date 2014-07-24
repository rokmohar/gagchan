<?php

namespace Media\Form;

use Zend\Form\Form;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class VoteForm extends Form
{
    /**
     * @param string $name
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
     * Add the slug element.
     * 
     * @return \Media\Form\MediaForm
     */
    protected function addSlug()
    {
        $this->add(array(
            'name'    => 'slug',
            'type'    => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Slug',
            ),
        ));
        
        return $this;
    }
    /**
     * Add the type element.
     * 
     * @return \Media\Form\MediaForm
     */
    protected function addType()
    {
        $this->add(array(
            'name'    => 'type',
            'type'    => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Type',
            ),
        ));
        
        return $this;
    }
}