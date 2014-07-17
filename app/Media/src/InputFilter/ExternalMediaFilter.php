<?php

namespace Media\InputFilter;

/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class ExternalMediaFilter extends AbstractMediaFilter
{
    /**
     * {@inheritDoc}
     */
    public function __construct()
    {
        parent::__construct();
        
        // Add filters
        $this
            ->addUrl()
        ;
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
            'required'   => true,
            'validators' => array(
                array(
                    'name' => 'Zend\Validator\Uri',
                    'options' => array(
                        'allow_relative' => false,
                        'allow_absolute' => true,
                    ),
                    'break_chain_on_failure' => true,
                ),
                array(
                    'name'    => 'Media\Validator\ValidatorChain',
                    'options' => array(
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
            'filters'   => array(
                array('name' => 'StringTrim'),
                array('name' => 'StripTags'),
            ),
        ));
        
        return $this;
    }
}