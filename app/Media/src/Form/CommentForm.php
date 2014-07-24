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
     * @param string $name
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
     * Add the comment element.
     * 
     * @return \Media\Form\MediaForm
     */
    protected function addComment()
    {
        $this->add(array(
            'name'    => 'comment',
            'type'    => 'Zend\Form\Element\Textarea',
            'options' => array(
                'label' => 'Your comment',
            ),
            'attributes' => array(
                'class'       => 'form-control',
                'style'       => 'resize: vertical;',
                'placeholder' => 'Your comment',
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add the submit element.
     * 
     * @return \Media\Form\MediaForm
     */
    protected function addSubmit()
    {
        $this->add(array(
            'name'    => 'submit',
            'type'    => 'Zend\Form\Element\Submit',
            'options' => array(
                'label' => 'Submit',
            ),
            'attributes' => array(
                'class' => 'btn btn-primary',
            ),
        ));
        
        return $this;
    }
}