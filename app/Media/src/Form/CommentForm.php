<?php

namespace Media\Form;

use Zend\Form\Form;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class CommentForm extends Form
{
    /**
     * @param String $name
     */
    public function __construct($name)
    {
        parent::__construct($name);
        
        $this
            ->addComment()
            ->addSubmit()
        ;
    }
    
    /**
     * Add comment text area.
     * 
     * @return \Media\Form\MediaForm
     */
    protected function addComment()
    {
        $this->add(array(
            'name'    => 'comment',
            'options' => array(
                'label' => 'Your comment',
            ),
            'attributes' => array(
                'type'        => 'textarea',
                'class'       => 'form-control',
                'style'       => 'resize: vertical;',
                'placeholder' => 'Your comment',
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add submit button.
     * 
     * @return \Media\Form\MediaForm
     */
    protected function addSubmit()
    {
        $this->add(array(
            'name'    => 'submit',
            'options' => array(
                'label' => 'Submit',
            ),
            'attributes' => array(
                'type'  => 'submit',
                'class' => 'btn btn-primary',
            ),
        ));
        
        return $this;
    }
}