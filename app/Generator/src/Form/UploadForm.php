<?php

namespace Generator\Form;

use Media\Form\MediaForm;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class UploadForm extends MediaForm
{
    /**
     * @param string $name
     * @param array  $options
     */
    public function __construct($name, $options)
    {
        parent::__construct($name, $options);
        
        // Add elements
        $this
            ->addFile()
            ->addUrl()
        ;
    }
    
    /**
     * Add the file element.
     * 
     * @return \Media\Form\UploadForm
     */
    protected function addFile()
    {
        $this->add(array(
            'name'    => 'file',
            'type'    => 'Zend\Form\Element\File',
            'options' => array(
                'label' => 'Select file ...',
            ),
            'attributes' => array(
                'class'       => 'form-control',
                'placeholder' => 'Select file ...',
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add the URL element.
     * 
     * @return \Media\Form\UploadForm
     */
    protected function addUrl()
    {
        $this->add(array(
            'name'    => 'url',
            'type'    => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'URL',
            ),
            'attributes' => array(
                'class'       => 'form-control',
                'placeholder' => 'URL',
            ),
        ));
        
        return $this;
    }
    
    /**
     * Enable file upload.
     * 
     * @return \Media\Form\UploadForm
     */
    public function enableFileUpload()
    {
        $this->setAttribute('enctype', 'multipart/form-data');
        
        return $this;
    }
}
