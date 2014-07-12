<?php

namespace Media\InputFilter;

use Zend\InputFilter\InputFilter;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 */
class MediaFilter extends InputFilter
{
    /**
     * {@inheritDoc}
     */
    public function __construct()
    {
        // Add input filters
        $this
            ->addName()
            ->addFile()
            ->addUrl()
            ->addCategory()
        ;
    }
    
    /**
     * Add  filter for form element.
     * 
     * @return \Media\InputFilter\MediaFilter
     */
    public function addName()
    {
        $this->add(array(
            'name'       => 'name',
            'required'   => true,
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'min' => 8,
                        'max' => 255,
                        
                        'break_chain_on_failure' => true,
                    ),
                ),
            ),
            'filters'   => array(
                array('name' => 'StringTrim'),
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add  filter for form element.
     * 
     * @return \Media\InputFilter\MediaFilter
     */
    public function addFile()
    {
        $this->add(array(
            'name'     => 'file',
            'required' => false,
            'validators' => array(
                array(
                    'name'    => 'Zend\Validator\File\Extension',
                    'options' => array(
                        'extension' => array('jpg', 'png'),
                        
                        'break_chain_on_failure' => true,
                    ),
                ),
                array(
                    'name'    => 'Zend\Validator\File\ImageSize',
                    'options' => array(
                        'minWidth'  => 160,
                        'minHeight' => 160,
                        'maxWidth'  => 640,
                        'maxHeight' => 640,
                        
                        'break_chain_on_failure' => true,
                    ),
                ),
                // Mime type error
                /*array(
                    'name' => 'Zend\Validator\File\IsImage',
                    'options' => array(
                        'break_chain_on_failure' => true,
                    ),
                ),*/
                // Mime type error
                /*array(
                    'name'    => 'Zend\Validator\File\MimeType',
                    'options' => array(
                        'mimeType'  => array('image/jpeg', 'image/jpg'),
                        
                        'break_chain_on_failure' => true,
                    ),
                ),*/
                array(
                    'name'    => 'Zend\Validator\File\Size',
                    'options' => array(
                        'min' => '10kB',
                        'max' => '500kB',
                        
                        'break_chain_on_failure' => true,
                    ),
                ),
                array(
                    'name' => 'Zend\Validator\File\UploadFile',
                    'options' => array(
                        'break_chain_on_failure' => true,
                    ),
                ),
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add filter for form element.
     * 
     * @return \Media\InputFilter\MediaFilter
     */
    public function addUrl()
    {
        $this->add(array(
            'name'       => 'url',
            'required'   => false,
            'validators' => array(
                array(
                    'name' => 'Media\Validator\ImageValidator',
                    'options' => array(
                        'break_chain_on_failure' => true,
                    ),
                ),
            ),
            'filters'   => array(
                array('name' => 'StringTrim'),
            ),
        ));
        
        return $this;
    }
    
    /**
     * Add filter for form element.
     * 
     * @return \Media\InputFilter\MediaFilter
     */
    public function addCategory()
    {
        $this->add(array(
            'name'     => 'category',
            'required' => true,
        ));
        
        return $this;
    }
}