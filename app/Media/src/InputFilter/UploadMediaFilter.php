<?php

namespace Media\InputFilter;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class UploadMediaFilter extends AbstractMediaFilter
{
    /**
     * {@inheritDoc}
     */
    public function __construct()
    {
        parent::__construct();
        
        // Add filters
        $this
            ->addFile()
        ;
    }
    
    /**
     * Add filter for form element.
     * 
     * @return \Media\InputFilter\MediaFilter
     */
    public function addFile()
    {
        $this->add(array(
            'name'       => 'file',
            'required'   => true,
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
                    'break_chain_on_failure' => true,
                ),
                array(
                    'name'    => 'Zend\Validator\File\ImageSize',
                    'options' => array(
                        'minWidth'  => 160,
                        'minHeight' => 160,
                        'maxWidth'  => 640,
                        'maxHeight' => 1280,
                    ),
                    'break_chain_on_failure' => true,
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
                    'break_chain_on_failure' => true,
                ),
                array(
                    'name'    => 'Zend\Validator\File\Size',
                    'options' => array(
                        'min' => '1kB',
                        'max' => '1MB',
                    ),
                    'break_chain_on_failure' => true,
                ),
                array(
                    'name' => 'Zend\Validator\File\UploadFile',
                    'break_chain_on_failure' => true,
                ),
            ),
        ));
        
        return $this;
    }
}