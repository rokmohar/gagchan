<?php

namespace Media\InputFilter;

use Zend\InputFilter\InputFilter;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
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
                    'name'    => 'Zend\Validator\StringLength',
                    'options' => array(
                        'min' => 8,
                        'max' => 255,
                    ),
                ),
            ),
            'filters'   => array(
                array('name' => 'HtmlEntities'),
                array('name' => 'StringTrim'),
                array('name' => 'StripTags'),
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
                        'extension' => array(
                            'gif',
                            'jpg',
                            'jpeg',
                            'png'
                        ),
                    ),
                ),
                array(
                    'name'    => 'Zend\Validator\File\ImageSize',
                    'options' => array(
                        'minWidth'  => 160,
                        'minHeight' => 160,
                        'maxWidth'  => 640,
                        'maxHeight' => 1280,
                    ),
                ),
                array(
                    'name'    => 'Zend\Validator\File\MimeType',
                    'options' => array(
                        'mimeType' => array(
                            'image/gif',
                            'image/jpeg',
                            'image/png',
                        ),
                    ),
                ),
                array(
                    'name'    => 'Zend\Validator\File\Size',
                    'options' => array(
                        'min' => '1kB',
                        'max' => '1MB',
                    ),
                ),
                array(
                    'name' => 'Zend\Validator\File\UploadFile',
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
                    'name'    => 'Media\Validator\ImageValidator',
                    'options' => array(
                        'validators' => array(
                            array(
                                'name'    => 'Zend\Validator\File\Extension',
                                'options' => array(
                                    'extension' => array(
                                        'gif',
                                        'jpg',
                                        'jpeg',
                                        'png'
                                    ),
                                ),
                            ),
                            array(
                                'name'    => 'Zend\Validator\File\ImageSize',
                                'options' => array(
                                    'minWidth'  => 160,
                                    'minHeight' => 160,
                                    'maxWidth'  => 640,
                                    'maxHeight' => 1280,
                                ),
                            ),
                            array(
                                'name'    => 'Zend\Validator\File\MimeType',
                                'options' => array(
                                    'mimeType' => array(
                                        'image/gif',
                                        'image/jpeg',
                                        'image/png',
                                    ),
                                ),
                            ),
                            array(
                                'name'    => 'Zend\Validator\File\Size',
                                'options' => array(
                                    'min' => '1kB',
                                    'max' => '1MB',
                                ),
                            ),
                        ),
                    ),
                ),
                array(
                    'name' => 'Zend\Validator\Uri',
                    'options' => array(
                        'allow_relative' => false,
                        'allow_absolute' => true,
                    ),
                ),
            ),
            'filters'   => array(
                array('name' => 'StringTrim'),
                array('name' => 'StripTags'),
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