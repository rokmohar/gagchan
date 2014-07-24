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
            ->addDelayAt()
        ;
    }
    
    /**
     * Add filter for the file form element.
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
                            'jpeg',
                            'jpg',
                            'png',
                        ),
                    ),
                    'break_chain_on_failure' => true,
                ),
                array(
                    'name'    => 'Zend\Validator\File\ImageSize',
                    'options' => array(
                        'minWidth'  => 80,
                        'minHeight' => 80,
                        'maxWidth'  => 2560,
                        'maxHeight' => 2560,
                    ),
                    'break_chain_on_failure' => true,
                ),
                array(
                    'name'    => 'Zend\Validator\File\MimeType',
                    'options' => array(
                        'magicFile' => false,
                        'mimeType'  => array(
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
                        'min' => '4kB',
                        'max' => '4MB',
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