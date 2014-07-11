<?php

namespace Media\Form;

use Zend\Form\Form;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class MediaForm extends Form
{
    /**
     * @param String $name
     */
    public function __construct($name)
    {
        parent::__construct($name);
        
        $this
            ->setAttribute('enctype', 'multipart/form-data')
        ;
        
        $this
            ->addName()
            ->addFile()
            ->addUrl()
            ->addCategory()
            ->addSubmit()
        ;
    }
    
    /**
     * Add media name input field.
     * 
     * @return \Media\Form\MediaForm
     */
    protected function addName()
    {
        // Media name
        $this->add(array(
            'name'    => 'name',
            'options' => array(
                'label' => 'Name',
            ),
            'attributes' => array(
                'type'        => 'text',
                'class'       => 'form-control',
                'placeholder' => 'Name',
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add media file input field.
     * 
     * @return \Media\Form\MediaForm
     */
    protected function addFile()
    {
        $this->add(array(
            'name'    => 'file',
            'options' => array(
                'label' => 'Upload',
            ),
            'attributes' => array(
                'type'        => 'file',
                'class'       => 'form-control',
                'placeholder' => 'Upload',
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add media URL input field.
     * 
     * @return \Media\Form\MediaForm
     */
    protected function addUrl()
    {
        $this->add(array(
            'name'    => 'url',
            'options' => array(
                'label' => 'URL',
            ),
            'attributes' => array(
                'type'        => 'text',
                'class'       => 'form-control',
                'placeholder' => 'URL',
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add media category select field.
     * 
     * @return \Media\Form\MediaForm
     */
    protected function addCategory()
    {
        $this->add(array(
            'type'    => 'Zend\Form\Element\Select',
            'name'    => 'category',
            'options' => array(
                'label' => 'Select Category',
                'value_options' => array(
                    '0' => 'GIF',
                    '1' => 'Cute',
                    '2' => 'Geeky',
                    '3' => 'Cosplay',
                    '4' => 'Meme',
                    '5' => 'Timely',
                    '6' => 'Girl',
                    '7' => 'Food',
                    '8' => 'WTF',
                    '9' => 'Comic',
                )
            ),
            'attributes' => array(
                'class' => 'form-control',
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
                'label' => 'Upload',
            ),
            'attributes' => array(
                'type'  => 'submit',
                'class' => 'btn btn-primary',
            ),
        ));
        
        return $this;
    }
}